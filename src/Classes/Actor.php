<?php
namespace Classes;
use Classes\Amount;
class Actor
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getLines()
    {
        $file = fopen('data.csv', 'r');
        $lines = [];
        while (is_array($line = fgetcsv($file, null, ','))) {
            $lines[] = $line;
        }
        return $lines;
    }

    public function calculateWeeklyDepositAmount(Transaction $transaction)
    {
        $lines = $this->getLines();
        $iteration = $transaction->getIteration();
        $i=0;
        $weeklyDepositAmount = $transaction->getConvertedAmount();
        $currency = $transaction->getCurrency();
        if($iteration!=0){
            for($i=0;$i<$iteration;$i++){
                $tmpTransaction = new Transaction($lines[$i][0],$lines[$i][1],$lines[$i][2],$lines[$i][3],$lines[$i][4],$lines[$i][5],$i);            
                $result = $transaction->isInSameWeek($tmpTransaction);
                if($result){
                    if($tmpTransaction->getConvertedAmount()>=1000){
                        $amount=new Amount($weeklyDepositAmount,$currency);
                        return $amount;                
                    }
                    $weeklyDepositAmount+=$tmpTransaction->getConvertedAmount();
                    // $weeklyDepositAmount=max($tmpTransaction->getAmount()-1000, 1000);
                    // if($weeklyDepositAmount>=1000){
                    //     $amount=new Amount(max($weeklyDepositAmount-1000, 0) ,$transaction->getCurrency());
                    //     return $amount;                
                    // }
                }
            }        
        }
        
        $amount=new Amount(max($weeklyDepositAmount-1000, 0),$transaction->getCurrency());
        return $amount;
    }
}