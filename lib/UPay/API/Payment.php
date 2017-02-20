<?php

namespace UPay\API;

class Payment extends Model
{
    /**
     * Get system id of the payment.
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->get('id');
    }

    public function setId($id)
    {
        return $this->set('id', $id);
    }

    /**
     * Information of payment amount
     * You should specify this value for every creating payment.
     *
     * @param Amount $amount
     *
     * @return $this
     */
    public function setAmount(Amount $amount)
    {
        return $this->set('amount', $amount);
    }

    /**
     * UUID of the service.
     *
     * @return string|null
     */
    public function getServiceId()
    {
        return $this->get('service_id');
    }

    /**
     * Information of payment amount.
     *
     * @return Amount|null
     */
    public function getAmount()
    {
        return $this->get('amount');
    }

    /**
     * UUID of the service.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setServiceId($value)
    {
        return $this->set('service_id', $value);
    }

    /**
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->get('order_id');
    }

    /**
     * Specify you identification of the payment, for example order pr invoice number
     * This value should be unique in one service.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setOrderId($value)
    {
        return $this->set('order_id', $value);
    }

    /**
     * @return AbstractPaymentMethod|null
     */
    public function getPaymentMethod()
    {
        return $this->get('payment_method');
    }

    /**
     * @param AbstractPaymentMethod $method
     *
     * @return $this
     */
    public function setPaymentMethod(AbstractPaymentMethod $method)
    {
        return $this->set('payment_method', $method);
    }

    public function create(Context $api)
    {
        $data = $this->serializeJson();
        $response = $api->request('POST', 'payments/payment', $data);

        if (isset($response->id)) {
            $this->set('id', $response->id);
        } else {
            throw new Exception('Wrong response: not contains id of payment');
        }

        if (isset($response->payment_method) && $this->getPaymentMethod()) {
            $this->getPaymentMethod()->unserializeJson($response->payment_method);
        }
    }
}
