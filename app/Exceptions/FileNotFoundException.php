<?php

namespace App\Exceptions;

class FileNotFoundException extends \Exception {
    protected $message = "Failed to open the file, maybe he's not existing";
}