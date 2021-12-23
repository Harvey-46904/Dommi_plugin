<?php
require __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;
global $woocommerce;
$woocommerce = new Client(
    'https://dommi.net/', 
    'ck_ae1b5bce8346b9fe963511a6cfca17512a98f364', 
    'cs_5f9d813b3fa984ed646fcca5451587863cb958c4',
    [
        'version' => 'wc/v3',
    ]
);