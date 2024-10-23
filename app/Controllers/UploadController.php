<?php

declare(strict_types=1);

namespace App\Controllers;
use App\View;
use App\Convertor;


class UploadController {

    public static function index() {
        $convertor = new Convertor();
        $invoices_array = $convertor->readCsv();
        $convertor->insert($invoices_array);
        return (new View('upload'))->render();
    }
}
