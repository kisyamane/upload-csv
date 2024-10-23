<?php

declare(strict_types=1);
namespace App;
use App\Model;
use App\Exceptions\FileNotFoundException;

class Convertor extends Model{
    public function properDateStr(string $date_str): string {
        $date_obj = \DateTime::createFromFormat('Y-m-d', $date_str);

        return $date_obj->format('M d, Y');
    }

    public function properAmountStr(string $amount_str, bool $colored=false): string {
        $amount_str = (string) number_format((float) $amount_str, 2, '.', ',');

        if ($amount_str[0] == '-') {
            $amount_str = '-$' . substr($amount_str, 1);
            if ($colored) {
                return '<span style="color: red;">' . $amount_str . '</span>';
            }
        } else {
            $amount_str = '$' . $amount_str;
            if ($colored) {
                return '<span style="color: green;">' . $amount_str . '</span>';
            }
        }
        return $amount_str;

    }

    public function properFormat(array $invoices):array {
        for ($i = 0; $i < count($invoices); $i++) {
            $invoices[$i]['Date'] = $this->properDateStr($invoices[$i]['Date']);
            $invoices[$i]['Amount'] = $this->properAmountStr($invoices[$i]['Amount'], true);
        }

        return $invoices;
    }

    public function incomeExpenseTotal(array $invoices): array {
        $income = $expense = $total = 0;

        foreach ($invoices as $invoice) {
            if ($invoice['Amount'] > 0) {
                $income += $invoice['Amount'];
            } else {
                $expense += $invoice['Amount'];
            }
        }

        $total = $income + $expense;

        $formated_income = $this->properAmountStr((string) $income);
        $formated_expense = $this->properAmountStr((string) $expense);
        $formated_total = $this->properAmountStr((string) $total);

        return [$formated_income, $formated_expense, $formated_total]; 
    }

    public function readCsv(): array {
        $result = [];
        try{
            $file = fopen($this->filepath, 'r');
        } catch(FileNotFoundException $e) {
            throw new FileNotFoundException($e->getMessage());
        }

        while(false !== ($data = fgetcsv($file, 100, ','))) {
            [$date, $check, $description, $amount] = $data;
            if ($date === 'Date') {
                continue;
            }

            [$day, $month, $year] = explode('/', $date);
            $formattedDate = "$year-$month-$day";

            $result[] = [
                'Date' => date('Y-m-d', strtotime($formattedDate)),
                'Check' => (int) $check,
                'Description' => $description,
                'Amount' => (float) substr($amount, 0, strlen($amount) - 1)
            ];
        }
        return $result;
    }
}