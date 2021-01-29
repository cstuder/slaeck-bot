<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use cstuder\SlaeckBot;

final class FetchTest extends TestCase
{
    public function testSearch(): void
    {
        $raw = SlaeckBot\Fetch::search('aaa');

        $this->assertIsString($raw);
    }

    public function testRandom(): void
    {
        $raw = SlaeckBot\Fetch::random();

        $this->assertIsString($raw);
    }
}
