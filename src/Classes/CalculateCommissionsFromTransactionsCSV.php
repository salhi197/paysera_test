<?php

declare(strict_types=1);

namespace Classes;

use Classes\Transaction;
class CalculateCommissionsFromTransactionsCSV 
{
    public $file;
    public $converter;
    
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function execute()
    {
        $comissions=[];
        $lines = $this->getLines();
        foreach($lines as $index=>$line){
            $transaction = new Transaction(
                $line[0],
                $line[1],
                $line[2],
                $line[3],
                $line[4],
                $line[5],
                $index);
            
            $comission = $transaction->calculateCommission();
            $comissions[]=$comission;
        }
        return $comissions;
    }

    public function getLines()
    {
        $file = fopen($this->file, 'r');
        $lines = [];
        while (is_array($line = fgetcsv($file, null, ','))) {
            $lines[] = $line;
        }
        return $lines;
    }
}