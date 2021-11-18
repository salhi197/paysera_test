<?php
require_once 'vendor/autoload.php';

$file = 'data.csv';

$transactionsCsv = new \Classes\CalculateCommissionsFromTransactionsCSV($file);

try {
    $transactions = $transactionsCsv->execute();
    echo implode("\n", $transactions);
} catch (Exception $ex) {
    echo $ex->getMessage();
    exit(1);
}

?>