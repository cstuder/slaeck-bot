<?php

/**
 * Manueller Test
 * 
 * Benötigt localhost:8000
 */
require_once __DIR__ . '/../vendor/autoload.php';

$url = 'http://localhost:8000/api/slashcommand.php';
$postdata = [
    'command' => '/bärndütsch',
    'text' => 'aaa'
];

$response = Requests::post($url, [], $postdata);

echo (json_encode(json_decode($response->body), JSON_PRETTY_PRINT));
