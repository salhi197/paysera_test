<?php

declare(strict_types=1);

namespace Classes;

use DateTimeImmutable;
use Classes\Actor;
use Classes\CommissionCalculator;
use Traversable;

class Transaction
{
    private $date;
    private $actor;
    private $operation;
    private $amount;
    private $iteration;
    const JPY_CONVERSION = '129.05';
    const USD_CONVERSION = '1.13';

    public function __construct( $date, $actor, $type,$operation,$amount,$currency,$iteration) {
        $this->date = $date;
        $this->actor = $actor;
        $this->type = $type;
        $this->operation = $operation;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->iteration = $iteration;
    }


    public function calculateCommission()
    {
        $comission = new CommissionCalculator($this);
        $fee = $comission->calculateCommission($this);
        return $fee;
    }


    public function getActor(): Actor
    {
        return new Actor((int)$this->actor);
    }

    public function getOperation()
    {
        return $this->operation;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getAmount() 
    {
        return $this->amount;
    }

    public function isInSameWeek(Transaction $transaction)
    {
        $firstDate = strtotime($transaction->getDate());
        $secondDate = strtotime($this->getDate());
        $result = "0";
        
        if($this->getActor()->getId()==$transaction->getActor()->getId()){
            if($transaction->getType()=="private" && $this->getType()=="private"){
                if($transaction->getOperation()=="withdraw" && $this->getOperation()=="withdraw"){
                    if(date('W', $firstDate) === date('W', $secondDate)){
                        if(date('Y', $firstDate) == date('Y', $secondDate)){
                            $result="1";
                        }
                    }
                }
            }             
        }
        return $result;

    }

    public function getConvertedAmount()
    {
        if($this->getCurrency()=="JPY"){
            return round($this->getAmount()/self::JPY_CONVERSION,2);
        }
        if($this->getCurrency()=="USD"){
            return round($this->getAmount()/self::USD_CONVERSION,2);
        }
        return $this->amount;
    }

    public function getIteration()
    {
        return $this->iteration;
    }

    public function getDate()
    {
        return $this->date;
    }

}