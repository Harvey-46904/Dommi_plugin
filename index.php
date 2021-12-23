<?php
require 'api.php';
$data = [
    'payment_method' => 'bacs',
    'payment_method_title' => 'nequi',
    'set_paid' => true,
    'billing' => [
        'first_name' => 'Harvey',
        'last_name' => 'Riascos',
        'address_1' => '969 Market',
        'address_2' => '',
        'city' => 'San Francisco',
        'state' => 'CA',
        'postcode' => '94103',
        'country' => 'US',
        'email' => 'john.doe@example.com',
        'phone' => '(555) 3226755570'
    ],
    'shipping' => [
        'first_name' => 'Sebas',
        'last_name' => 'Doe',
        'address_1' => '969 Market',
        'address_2' => '',
        'city' => 'San Francisco',
        'state' => 'CA',
        'postcode' => '94103',
        'country' => 'US'
    ],
    'line_items' => [
        [
            'product_id' => 415,
            'quantity' =>1
        ]
    ]
];

print_r($woocommerce->post('orders', $data));