<?php

namespace UPay\API;

/**
 * Payment type, where the source of the money is mobile phone accounts.
 */
class MobileCommerce extends AbstractPaymentMethod
{
    protected $payer;

    public function __construct($payerPhone = null)
    {
        $this->set('type', 'mobile_commerce');
        $this->setPayerPhone($payerPhone);
    }

    /**
     * @return string|null
     */
    public function getPayerPhone()
    {
        return $this->get('phone');
    }

    /**
     * Payer phone number with country code, for example 79001234567
     * If you specify valid payer phone, transaction initializes without redirect to payment form.
     *
     * @param string $phone
     *
     * @return $this
     */
    public function setPayerPhone($phone)
    {
        return $this->set('phone', $phone);
    }

    /**
     * @return string|null
     */
    public function getOperator()
    {
        return $this->get('operator');
    }
}
