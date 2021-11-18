<?php

namespace Classes;

use Classes\Transaction;
use Classes\DepositCommission;
use Classes\withdrawBusinessCommission;
use Classes\withdrawPrivateCommission;

class CommissionCalculator
{
    private $deposit_commission;
    private $transaction;
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->deposit_commission = new DepositCommission();
        $this->withdraw_business_commission = new withdrawBusinessCommission();
        $this->withdraw_private_commission = new withdrawPrivateCommission();
    }

    public function calculateCommission(Transaction $transaction)
    {
        return $this
            ->strategy($transaction)
            ->calculate($transaction);
    }

    protected function strategy(Transaction $transaction)
    {
        if($transaction->getOperation()=="deposit"){
            return $this->deposit_commission;
        }elseif($transaction->getOperation()=="withdraw" && $transaction->getType()=="business"){
            return $this->withdraw_business_commission;
        }else{
            return $this->withdraw_private_commission;
        }
    }
}