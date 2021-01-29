<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use cstuder\SlaeckBot;

final class ParserTest extends TestCase
{
    protected array $searchResultKeys = ['text', 'url', 'translation'];

    public function testParseSearchNothingFound(): void
    {
        $raw = SlaeckBot\Fetch::search('asdfasdfasdf');
        $this->assertIsString($raw);

        $results = SlaeckBot\Parse::parseRawSearch($raw);
        $this->assertIsArray($results);
        $this->assertEmpty($results);

        $this->assertFalse(SlaeckBot\Parse::additionalResultsOnOtherPages($raw));
    }

    public function testParseSearchSingleResult(): void
    {
        $raw = SlaeckBot\Fetch::search('henusode');
        $this->assertIsString($raw);

        $results = SlaeckBot\Parse::parseRawSearch($raw);
        $this->assertIsArray($results);
        $this->assertCount(1, $results); // Hoffen wir das bleibt so

        foreach ($this->searchResultKeys as $key) {
            $this->assertArrayHasKey($key, $results[0]);
            $this->assertNotEmpty($results[0][$key]);
        }
        $this->assertFalse(SlaeckBot\Parse::additionalResultsOnOtherPages($raw));
    }

    public function testParseSearchMultipleResults(): void
    {
        $raw = SlaeckBot\Fetch::search('aaa');
        $this->assertIsString($raw);

        $results = SlaeckBot\Parse::parseRawSearch($raw);
        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(3, count($results)); // Vokabular könnte jederzeit ändern

        foreach ($results as $result) {
            foreach ($this->searchResultKeys as $key) {
                $this->assertArrayHasKey($key, $result);
                $this->assertNotEmpty($result[$key]);
            }
        }

        $this->assertFalse(SlaeckBot\Parse::additionalResultsOnOtherPages($raw));
    }

    public function testParseSearchMoreThanTen(): void
    {
        $raw = SlaeckBot\Fetch::search('a');
        $this->assertIsString($raw);

        $results = SlaeckBot\Parse::parseRawSearch($raw);
        $this->assertIsArray($results);
        $this->assertCount(10, $results); // Webseite zeigt max. 10 Einträge

        foreach ($results as $result) {
            foreach ($this->searchResultKeys as $key) {
                $this->assertArrayHasKey($key, $result);
                $this->assertNotEmpty($result[$key]);
            }
        }

        $this->assertTrue(SlaeckBot\Parse::additionalResultsOnOtherPages($raw));
    }
}
