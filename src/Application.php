<?php 

namespace PD;

use PD\order\Pizza;
use PD\service\Oven;
use PD\service\Router;
use PD\order\Invoice;


class Application{
    private $timeOrder;
    private $numOrder;
    private $stackOrder;
    private $stackInvoice;
    private $oven;
    private $deliv;
    
    public function __construct(){
        $this->timeOrder = new \DateTime('2018-12-01 10:0:0');
        $this->numOrder = rand(10, 100); //кол-во заказов 
        $this->stackOrder = new \SplStack(); 
        $this->stackInvoice = new \SplStack();
        $this->oven = new Oven();
        $this->deliv = new Router(); 
    }

    public function main(){
        for($i = 0; $i < $this->numOrder; $i++){
            $this->timeOrder->modify('+ '.rand(1, 30). ' minutes');
            $this->stackOrder[] = new Pizza(clone $this->timeOrder, [rand(-1000, 1000), rand(-1000, 1000)]);
        }
        $this->calc();        
    }

    private function calc(){
        $delivpizza = null;
        $res;
        $invoice = [];
        $this->stackOrder->rewind();
        while($this->stackOrder->valid()){
            $s =  $this->stackOrder->current();
            $hotpizza = $this->oven->require($s);
            $res = $this->deliv->require($hotpizza);
            if(!$delivpizza) $delivpizza = $res;
            else if(count($res) < count($delivpizza)){
                foreach ($delivpizza as $dp) print(htmlspecialchars($dp->status()).'<br>');
                $this->stackInvoice[] = $invoice;
                $res = $this->deliv->require($hotpizza);
            }
            $delivpizza = $res;
            $invoice[] = $this->deliv->getOrder();
            $this->stackOrder->next();
        }
        foreach ($delivpizza as $dp) print($dp->status().'<br>');
        print('<br>');
        $this->stackInvoice[] = $invoice;
        $this->stackInvoice->rewind();
        print(count($this->stackInvoice));
        print('<script>');
        while($this->stackInvoice->valid()){
            $invoice = $this->stackInvoice->current();
            $invoice->toConsole();
            $this->stackInvoice->next();
        }
        print('</script>');
        print('<br>END');
    }
}
?>