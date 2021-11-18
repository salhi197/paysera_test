<?php

declare(strict_types=1);

namespace Classes;

class Amount
{
    private $amount;
    private $currency;
    const JPY_CONVERSION = '129.05';
    const USD_CONVERSION = '1.13';

    public function __construct($amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function convert()
    {
        if($this->getCurrency()=="JPY"){
            return round($this->getAmount()*self::JPY_CONVERSION,2);
        }
        if($this->getCurrency()=="USD"){
            return round($this->getAmount()*self::USD_CONVERSION,2);
        }
        return $this->amount;
    }
}