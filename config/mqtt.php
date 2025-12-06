<?php
return [
    'default' => [
        'host' => env('MQTT_HOST'),
        'port' => env('MQTT_PORT'),
        'username' => env('MQTT_USERNAME'),
        'password' => env('MQTT_PASSWORD'),
        'client_id' => 'LaravelControlPanel',
        'tls' => env('MQTT_TLS', false),
    ],
];
