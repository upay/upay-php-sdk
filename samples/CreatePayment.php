<?php

require_once __DIR__.'/bootstrap.php';

use UPay\API\Payment;
use UPay\API\MobileCommerce;
use UPay\API\Exception as UPayException;
use UPay\API\Amount;

$payment = new Payment();
$payment->setServiceId('9d9c5020-3b58-4599-8b07-1088fde3515b');
$payment->setAmount(new Amount(100, 'RUB'));
$payment->setPaymentMethod(new MobileCommerce('79001234567'));
$payment->setOrderId(uniqid('my-order-id', false));

try {
    $payment->create($api);
    echo 'Payment #', $payment->getId(), ' was created.', PHP_EOL;
    echo 'Operator', $payment->getPaymentMethod()->getOperator(), PHP_EOL;
} catch (UPayException $e) {
    echo '[ERROR] '.$e->getMessage(), PHP_EOL;
}
