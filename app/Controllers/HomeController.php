<?php

declare(strict_types=1);

namespace App\Controllers;
use App\View;

class HomeController {
    public static function index(): string {
        return (new View('index'))->render();
    }
}