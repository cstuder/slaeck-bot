<?php

/**
 * Nimmt Slashcommand /bärndütsch entgegen und antwortet
 * 
 * Simples prozedurales Skript, reicht vollkommen.
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
if (empty($command) || empty($word)) {
    $payload = [
        'response_type' => 'ephemeral',
        'text' => 'Häh?'
    ];

    echo json_encode($payload);
    die(1);
}

// Query absetzen
$url = QUERY_URL . urlencode($word);
$raw = Requests::get($url)->body;

// Übersetzungen finden
libxml_use_internal_errors(true); // DOMDocument schlucht HTML5 nicht
$dom = new DOMDocument();
$dom->loadHTML($raw);

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
        $gefunden = 'Nüt';
        break;

    case 1:
        $gefunden = 'Ei Iitrag';
        break;

    default:
        $gefunden = count($results) . ' Iiträg';
        break;
}

$gefundentext = $gefunden . " gfunde für `{$word}` uf <$url|berndeutsch.ch>";

$resultlist = '';
foreach ($results as $result) {
    $resultlist .= "• <{$result['url']}|{$result['text']}>: {$result['translation']}\n";
}

$response = [
    'response_type' => 'in_channel',
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
                'text' => empty($resultlist) ? ' ' : $resultlist,
            ],
        ],
    ],
];

echo json_encode($response);
