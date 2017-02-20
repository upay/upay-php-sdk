<?php


// Include the composer Autoloader
// The location of your project's vendor autoloader.
$composerAutoload = dirname(dirname(dirname(__DIR__))).'/autoload.php';
if (!file_exists($composerAutoload)) {
    // If the project is used as its own project, it would use rest-api-sdk-php composer autoloader.
    $composerAutoload = dirname(__DIR__).'/vendor/autoload.php';
    if (!file_exists($composerAutoload)) {
        $composerAutoload = null;

        spl_autoload_register(function ($class) {
            $file = dirname(__DIR__).'/lib/'.str_replace('\\', '/', $class).'.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}

if ($composerAutoload) {
    require_once $composerAutoload;
}

// For debugging purpose only
error_reporting(E_ALL);
ini_set('display_errors', '1');

use UPay\API\Context;

$api = new Context(
    'endpoint-url',
    'esgSRYdaKBwamZz5fQnc4pjYSgrHpokrskzrZ3EBFuk6m6hhrb2eSYF2HJzR16bd',
    'RnEweyykJun8pn9hThhEfoqBz58m9bEqc2xUZJj2EMEcHUtexawTunnudQPcZQz7'
);

return $api;
