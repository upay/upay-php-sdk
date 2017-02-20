<?php

namespace UPay\API;

abstract class Model
{
    protected $data = array();

    protected function get($key, $default = null)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return $default;
    }

    protected function set($key, $value)
    {
        if (null === $value || '' === $value) {
            unset($this->data[$key]);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    protected function serializeJson()
    {
        $result = array();
        foreach ($this->data as $key => $value) {
            if ($value instanceof self) {
                $value = $value->serializeJson();
            }

            $result[$key] = $value;
        }

        return $result;
    }

    protected function unserializeJson($data, array $map = array())
    {
        foreach ($data as $key => $value) {
            if (isset($map[$key])) {
                $v = new $map[$key]();
                $v->unserializeJson($value);
                $value = $v;
            }

            $this->data[$key] = $value;
        }
    }
}
