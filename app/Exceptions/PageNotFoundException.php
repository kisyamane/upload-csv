<?php

namespace App\Exceptions;

class PageNotFoundException extends \Exception {
    protected $message = "Page not found";
    protected $code = 404;
}