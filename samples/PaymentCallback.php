<?php

require_once __DIR__.'/bootstrap.php';

use UPay\API\PaymentCallback;

$callback = PaymentCallback::fromGlobals();

switch ($callback->getAction()) {
    case PaymentCallback::ACTION_CHECK:
        // do check
        if ($callback->getAmount()->getTotal() < 100) {
            $callback->respondError('to small amount');

            return;
        }

        $callback->respondSuccess();

        return;

    case PaymentCallback::ACTION_PAY:
        // do pay

        $callback->respondSuccess();

        return;

    case PaymentCallback::ACTION_CANCEL:
        // this payment cannot be payed
        $callback->respondSuccess();

        return;
}
