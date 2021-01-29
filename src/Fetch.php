<?php

declare(strict_types=1);

namespace cstuder\SlaeckBot;

use Requests;

/**
 * Hol dir die Daten von berndeutsch.ch
 */
class Fetch
{
    protected const SEARCH_URL = 'https://www.berndeutsch.ch/search?q=';
    protected const RANDOM_URL = 'https://www.berndeutsch.ch/random';
    protected const USERAGENT = 'slaek-bot.existenz.ch';

    public static function getSearchUrl(String $query): String
    {
        return
            self::SEARCH_URL . urlencode($query);
    }

    public static function search(String $query): String
    {
        $url = self::getSearchUrl($query);

        return self::get($url);
    }

    public static function random(): String
    {
        $url = self::RANDOM_URL;

        return self::get($url);
    }

    protected static function get(String $url): String
    {
        return
            Requests::get($url, [], ['useragent' => self::USERAGENT])->body;
    }
}
