<?php

/**
 * Nimmt Slashcommand /bärndütsch entgegen und antwortet
 */

// Initialisierung
require_once __DIR__ . '/../../vendor/autoload.php';
define('QUERY_URL', 'https://www.berndeutsch.ch/search?q=');
header('Content-Type: application/json');

// Command entgegen nehmen
// Notiz: Wir kümmern uns nicht darum, woher der Request kommt. Soll doch diesen Endpoint hier brauchen wer will.

$command = $_POST['command'] ?? null;
$word = $_POST['text'] ?? null;

// Leichte Validation
if (is_null($command) || is_null($word)) {
    $payload = [
        'response_type' => 'ephemeral',
        'text' => 'Häh?'
    ];

    echo json_encode($payload);
    die(1);
}

// Query absetzen
$url = QUERY_URL . urlencode($word);
$raw = Requests::get($url);

// Übersetzungen finden
libxml_use_internal_errors(true); // DOMDocument schlucht HTML5 nicht
$dom = new DOMDocument();
$dom->loadHTML($raw->body);

$results = [];

$h3s = $dom->getElementsByTagName('h3');
foreach ($h3s as $entry) {
    $results[] = [
        'text' => $entry->textContent,
        'url' => $entry->getElementsByTagName('a')->item(0)->getAttribute('href'),
        'translation' => $entry->nextSibling->nextSibling->textContent,
    ];
}

// Response zurückliefern
switch (count($results)) {
    case 0:
        $gefunden = 'Keine Einträge';
        break;

    case 1:
        $gefunden = 'Ein Eintrag';
        break;

    default:
        $gefunden = count($results) . ' Einträge';
        break;
}

$gefundentext = $gefunden . ' gefunden auf <$url|berndeutsch.ch>';

$resultlist = '';
foreach ($results as $result) {
    $resultlist .= "- <{$result['url']}|{$result['text']}>: {$result['translation']}\\n";
}

$response = [
    'text' => $gefundentext,
    'blocks' => [
        [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $gefundentext,
            ],
        ],
        [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $resultlist,
            ],
        ],
    ],
];

echo json_encode($response);
