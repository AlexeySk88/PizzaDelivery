<?php 

namespace PD;

use PD\order\Pizza;
use PD\service\Oven;
use PD\service\Router;
use PD\order\Invoice;


class Application{
    private $timeOrder;
    private $numOrder;
    private $queueOrder;
    private $queueInvoice;
    private $oven;
    private $deliv;
    
    public function __construct(){
        $this->timeOrder = new \DateTime('2018-12-01 10:0:0');
        $this->numOrder = rand(10, 100); //кол-во заказов 
        $this->queueOrder = new \SplQueue(); 
        $this->queueInvoice = new \SplQueue();
        $this->oven = new Oven();
        $this->deliv = new Router(); 
    }

    public function main(){
        for($i = 0; $i < $this->numOrder; $i++){
            $this->timeOrder->modify('+ '.rand(1, 30).' minutes');
            $this->queueOrder[] = new Pizza(clone $this->timeOrder, [rand(-1000, 1000), rand(-1000, 1000)]);
        }
        $this->calc();        
    }

    private function calc(){
        echo("№\tВремя поступления\tВремя готовки\tX\tY\n------------------------------------------------------------\n");
        $res = null;
        $subres;
        $invoice = [];
        $this->queueOrder->rewind();
        while($this->queueOrder->valid()){
            $hotpizza = $this->oven->require($this->queueOrder->current());
            $subres = $this->deliv->require($hotpizza);
            if(!$res) $res = $subres;
            else if(count($subres) <= count($res)){
                foreach ($res as $dp) echo($dp->status()."\n");
                $this->queueInvoice[] = $invoice;
                $subres = $this->deliv->require($hotpizza);
            }
            $res = $subres;
            $invoice = $this->deliv->getOrder();
            $this->queueOrder->next();
        }
        foreach ($res as $dp) echo($dp->status()."\n");
        $this->queueInvoice[] = $invoice;
        $this->queueInvoice->rewind();
        echo("\n№\tВремя доставки1\t№\tВремя доставки2\t№\tВремя доставки3\n-------------------------------------------------------------------------\n");
        while($this->queueInvoice->valid()){
            $inv = $this->queueInvoice->current();
            echo($inv->status());
            $this->queueInvoice->next();
        }
    }
}
?>