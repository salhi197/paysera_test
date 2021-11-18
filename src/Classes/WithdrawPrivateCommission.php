<?php

namespace Classes;

use Classes\Amount;
use Classes\Transaction;

class withdrawPrivateCommission
{
    const COMMISSION_RATE = '0.003';

    public function __construct()
    {
    }

    public function calculate(Transaction $transaction)
    {
        $actor = $transaction->getActor();
        $weeklyDepositAmount=$actor->calculateWeeklyDepositAmount($transaction);//Amount Type
        return round($weeklyDepositAmount->convert()*self::COMMISSION_RATE,3);
    }
}