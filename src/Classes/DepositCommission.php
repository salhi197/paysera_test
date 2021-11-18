<?php

namespace Classes;

use Classes\Amount;
use Classes\Transaction;

class DepositCommission 
{
    const COMMISSION_RATE = '0.0003';
    private $ceiling;

    public function __construct()
    {
        $this->ceiling =3;// new Amount('5.0', 'EUR', $converter);
    }

    public function calculate(Transaction $transaction)
    {
        return $transaction->getAmount()*0.0003;
    }
}