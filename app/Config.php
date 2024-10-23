<?php

declare(strict_types=1);

namespace App;

class Config {

    private array $config = [];

    public function __construct(array $env) {
        $this->config = [
            'db' => [
                'host' => $env['DB_HOST'],
                'driver' => $env['DB_DRIVER'] ?? 'mysql',
                'db' => $env['DB_DATABASE'],
                'user' => $env['DB_USER'],
                'pass' => $env['DB_PASS'],
            ]
        ];
    }

    public function __get(string $name): array {
        return $this->config[$name];
    }
}