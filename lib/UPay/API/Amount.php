<?php

namespace UPay\API;

class Amount extends Model
{
    public function __construct($total = null, $currency = null)
    {
        $this->setTotal($total);
        $this->setCurrency($currency);
    }

    public function getTotal()
    {
        return $this->get('total');
    }

    public function setTotal($value)
    {
        return $this->set('total', $value);
    }

    public function getCurrency()
    {
        return $this->get('currency');
    }

    public function setCurrency($value)
    {
        return $this->set('currency', $value);
    }
}
