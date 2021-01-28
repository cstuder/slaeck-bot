<?php

/**
 * Nimmt Slashcommand /bärndütsch entgegen und antwortet
 * 
 * Simples prozedurales Skript, reicht vollkommen.
 */

// Initialisierung
require_once __DIR__ . '/../../vendor/autoload.php';

use cstuder\SlaeckBot;

// Command entgegen nehmen
// Notiz: Wir kümmern uns nicht darum, woher der Request kommt. Soll doch diesen Endpoint hier brauchen wer will.

$command = $_POST['command'] ?? null;
$text = $_POST['text'] ?? null;

// Leichte Validation
if (empty($command)) {
    $payload = [
        'response_type' => 'ephemeral',
        'text' => 'Häh?'
    ];

    SlaeckBot\Output::json($payload);
    die(1);
}

// Query absetzen
$raw = SlaeckBot\Fetch::search($text);

// Übersetzungen finden
$results = SlaeckBot\Parse::parseRawSearch($raw);

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

$searchUrl = SlaeckBot\Fetch::getSearchUrl($text);
$gefundentext = $gefunden . " gfunde für `{$text}` uf <$searchUrl|berndeutsch.ch>";

$resultlist = '';
foreach ($results as $result) {
    $resultlist .= "• <{$result['url']}|{$result['text']}>: {$result['translation']}\n";
}

$payload = [
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

// Antwort liefern
SlaeckBot\Output::json($payload);
