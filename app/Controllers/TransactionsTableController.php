<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Convertor;
use App\View;

class TransactionsTableController {
    public static function index() {
        $convertor = new Convertor();
        $invoices = $convertor->get();
        $_SESSION['invoices'] = $convertor->properFormat($invoices);
        [$_SESSION['income'], $_SESSION['expense'], $_SESSION['total']] = $convertor->incomeExpenseTotal($invoices); 
        return (new View('transactions'))->render();
    }
}