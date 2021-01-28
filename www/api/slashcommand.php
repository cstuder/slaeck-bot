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

// Command ausführen
$response = [];
switch ($command) {
    default:
        $response = SlaeckBot\Response::generateError();
        break;

    case "/berndeutsch":
    case "/baernduetsch":
    case "/bärndütsch":
        // Validierung
        if (empty(trim($text))) {
            $response = SlaeckBot\Response::generateError();
            break;
        }

        // Query absetzen
        $raw = SlaeckBot\Fetch::search($text);

        // Übersetzungen finden
        $results = SlaeckBot\Parse::parseRawSearch($raw);

        // Response zurückliefern
        $response = SlaeckBot\Response::generateSearchResults($text, $results);
        break;
}

// Antwort liefern
SlaeckBot\Output::json($response);
