<?php

declare(strict_types=1);

namespace cstuder\SlaeckBot;

/**
 * Generiert Slack Blocks Objekte zur Antwort
 */
class Response
{
    public static function generateSearchResults(String $query, array $results, bool $additionalResults): array
    {
        switch (count($results)) {
            case 0:
                $gefunden = 'Nüt';
                break;

            case 1:
                $gefunden = 'Ei Iitrag';
                break;

            default:
                if ($additionalResults) {
                    $gefunden = 'No vil meh Iiträg';
                } else {
                    $gefunden = count($results) . ' Iiträg';
                }
                break;
        }

        $searchUrl = Fetch::getSearchUrl($query);
        $gefundentext = $gefunden . " gfunde für _{$query}_ uf <$searchUrl|berndeutsch.ch>";

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

    public static function generateUserError(): array
    {
        $response = [
            'response_type' => 'ephemeral',
            'text' => 'Häh? Ha di itz grad nid verstande.'
        ];

        return $response;
    }

    public static function generateInternalError(): array
    {
        $response = [
            'response_type' => 'ephemeral',
            'text' => 'Sorry, interne Fähler, probiers nomau.'
        ];

        return $response;
    }
}
