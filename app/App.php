<?php

declare(strict_types=1);

namespace App;
use App\Exceptions;

use App\Exceptions\PageNotFoundException;

class App {
    private static $convertor;

    public function __construct(protected Router $router, protected array $request) {
        static::$convertor = new Convertor();
    }


    public function run() {
        try {
            echo $this->router->resolve($this->request['uri'], $this->request['method']);
        } catch(PageNotFoundException $e) {
            http_response_code(404);
            throw new PageNotFoundException($e->getMessage(), $e->getCode());
        }
    }
}