<?php

namespace UPay\API;

class PaymentCallback extends Model
{
    const ACTION_CHECK = 'check';
    const ACTION_PAY = 'pay';
    const ACTION_CANCEL = 'cancel';

    /**
     * Callback action.
     * One of {PaymentCallback::ACTION_CHECK, PaymentCallback::PAY}.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->get('action');
    }

    /**
     * Get system id of the payment.
     *
     * @return string
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
     * Information of payment amount.
     *
     * @return Amount
     */
    public function getAmount()
    {
        return $this->get('amount');
    }

    /**
     * UUID of the service.
     *
     * @return string
     */
    public function getServiceId()
    {
        return $this->get('service_id');
    }

    /**
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->get('order_id');
    }

    public function respondSuccess()
    {
        echo json_encode(array(
            'status' => 'success',
            'payment_id' => $this->get('id'),
        ));
    }

    public function respondError($reason = null)
    {
        $data = array(
            'status' => 'error',
            'payment_id' => $this->get('id'),
        );

        if ($reason) {
            $data['error']['message'] = $reason;
        }

        echo json_encode($data);
    }

    public static function fromGlobals()
    {
        $r = new self();

        $method = $_SERVER['REQUEST_METHOD'];
        $url = 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.
            $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $json = file_get_contents('php://input');

        $r->set('method', $method);
        $r->set('url', $url);
        $r->set('data', $json);

        $json = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Request content should be json');
        }

        $r->unserializeJson($json);

        if (
            !$r->getAction() ||
            !$r->getId() ||
            !$r->getAmount() ||
            !$r->getServiceId()
        ) {
            throw new Exception('Wrong request');
        }

        return $r;
    }

    protected function unserializeJson(array $data, array $map = array())
    {
        $map = array(
            'amount' => 'UPay\API\Amount',
        );

        parent::unserializeJson($data, $map);
    }
}
