<?php

declare(strict_types=1);

namespace cstuder\SlaeckBot;

class Output
{
    public static function json(array $payload): void
    {
        header('Content-Type: application/json');
        echo json_encode($payload);
    }
}
