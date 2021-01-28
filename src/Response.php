<?php

declare(strict_types=1);

namespace cstuder\SlaeckBot;

/**
 * Generiert Slack Blocks Objekte zur Antwort
 */
class Response
{
    public static function generateSearchResults(String $query, array $results): array
    {
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

        $searchUrl = Fetch::getSearchUrl($query);
        $gefundentext = $gefunden . " gfunde für `{$query}` uf <$searchUrl|berndeutsch.ch>";

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
                        'text' => empty($resultlist) ? ' ' : $resultlist,
                    ],
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => $gefundentext,
                    ],
                ],
            ],
        ];

        return $response;
    }

    public static function generateError(): array
    {
        $response = [
            'response_type' => 'ephemeral',
            'text' => 'Häh?'
        ];

        return $response;
    }
}
