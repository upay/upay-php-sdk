<?php

namespace UPay\API;

class Context
{
    protected $token;
    protected $secret;
    protected $endPoint;

    public function __construct($endPoint, $token, $secret)
    {
        $this->endPoint = rtrim($endPoint, '/').'/v1/';
        $this->token = $token;
        $this->secret = $secret;
    }

    /**
     * @internal
     *
     * @param string $method
     * @param string $path
     * @param array  $postData
     *
     * @return array
     *
     * @throws Exception
     */
    public function request($method, $path, $postData = null)
    {
        $url = $this->endPoint.$path;

        $opts = array(
            'http' => array(
                'method' => strtoupper($method),
            ),
        );

        $headers = array();

        if ($postData) {
            $postData = json_encode($postData);
            $opts['http']['content'] = $postData;
            $headers[] = 'Content-Type: application/json; charset=utf-8';
        } else {
            $postData = '';
        }

        $headers[] = 'X-Auth-Token: '.$this->token;
        $headers[] = 'X-Auth-Sign: '.$this->sign($method, $url, $postData);

        if ($headers) {
            $opts['http']['header'] = implode("\r\n", $headers);
        }

        $context = stream_context_create($opts);
        $result = @file_get_contents($url, false, $context);

        if (false === $result) {
            $err = error_get_last();

            throw new Exception('Could not complite http request. Error: '.$err['message']);
        }

        $result = json_decode($result);
        if (!$result || !isset($result->status)) {
            throw new Exception('Bad Response given');
        }

        if ($result->status === 'success' && isset($result->result)) {
            return $result->result;
        } elseif (isset($result->error->message)) {
            throw new Exception('Error: '.$result->error->message);
        }

        throw new Exception('Bad Response given');
    }

    protected function sign($method, $url, $data)
    {
        $data = $method.'|'.$url.'|'.$data;

        return hash_hmac('sha512', $data, $this->secret.':'.$this->token);
    }
}
