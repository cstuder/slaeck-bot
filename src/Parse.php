<?php

declare(strict_types=1);

namespace cstuder\SlaeckBot;

/**
 * Konvertier das rohe HTML in Objekte
 */
class Parse
{
    /**
     * Findet die Resultate einer Suche
     * 
     * @param String $raw HTML
     * @return array Resultate [text, url, translation]
     */
    public static function parseRawSearch(String $raw): array
    {
        $results = [];

        // Übersetzungen finden
        libxml_use_internal_errors(true); // DOMDocument schluckt HTML5 nicht
        $dom = new \DOMDocument();
        $dom->loadHTML($raw);

        $h3s = $dom->getElementsByTagName('h3');
        foreach ($h3s as $entry) {
            $results[] = [
                'text' => $entry->textContent,
                'url' => $entry->getElementsByTagName('a')->item(0)->getAttribute('href'),
                'translation' => $entry->nextSibling->nextSibling->textContent,
            ];
        }

        return $results;
    }

    public static function additionalResultsOnOtherPages(String $raw): bool
    {
        return strpos($raw, '<ul class="pagination"') != false;
    }

    public static function parseRawRandom(String $raw): array
    {
        $word = [];

        // TODO implement this

        return $word;
    }
}
