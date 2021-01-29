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

try {
    switch ($command) {
        default:
            $response = SlaeckBot\Response::generateUserError();
            break;

        case "/bärndütsch":
            // Validierung
            $trimmedText = trim($text);
            if (empty($trimmedText)) {
                $response = SlaeckBot\Response::generateUserError();
                break;
            }

            // Query absetzen
            $raw = SlaeckBot\Fetch::search($trimmedText);

            // Übersetzungen finden
            $results = SlaeckBot\Parse::parseRawSearch($raw);

            // Response zurückliefern
            $response = SlaeckBot\Response::generateSearchResults($trimmedText, $results);
            break;
    }
} catch (Exception $e) {
    $response = SlaeckBot\Response::generateInternalError();
}

// Antwort liefern
SlaeckBot\Output::json($response);
