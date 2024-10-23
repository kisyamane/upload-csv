<?php

declare(strict_types=1);

namespace App;
use \App\Exceptions\ViewNotFoundException;

class View {

    public function __construct(
        protected string $view,
        protected array $params = []
    ) {}

    public static function make(string $view, array $params = []) {
        return new static($view, $params);
    }

    public function render(): string {
        ob_start();

        $full_view_path = VIEW_PATH . $this->view . '.php';

        if (! file_exists($full_view_path)) {
            throw new ViewNotFoundException($full_view_path);
        }

        include $full_view_path;

        return (string) ob_get_clean();
    }
}