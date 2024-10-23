<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['invoices'] as $invoice): ?>
                    <tr>
                        <td><?= $invoice['Date'] ?></td>
                        <td><?= $invoice['Check'] === 0 ? '' : $invoice['Check'] ?></td>
                        <td><?= $invoice['Description'] ?></td>
                        <td><?= $invoice['Amount'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= $_SESSION['income'] ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= $_SESSION['expense'] ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= $_SESSION['total'] ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>