<?php 

namespace PD;

use PD\order\Pizza;
use PD\service\Oven;
use PD\service\Router;


class Application{
    private $timeOrder;
    private $numOrder;
    private $stackOrder;
    private $oven;
    private $deliv;
    
    public function __construct(){
        $this->timeOrder = new \DateTime('2018-12-01 10:0:0');
        $this->numOrder = rand(10, 100); //кол-во заказов
        $this->stackOrder = new \SplStack(); 
        $this->oven = new Oven();
        $this->deliv = new Router(); 
    }

    public function begin(){
        for($i = 0; $i < $numOrder; $i++){
            $this->timeOrder->modify('+ '.rand(1, 30). ' minutes');
            $this->stackOrder[] = new Pizza($timeOrder, [rand(-1000, 1000), rand(-1000, 1000)]);
            $this->config();
        }
    }

    public function testBegin(){
        $this->stackOrder[] = new Pizza(new \DateTime('2018-12-01 10:0:0'), [150, 400]);
        $this->stackOrder[] = new Pizza(new \DateTime('2018-12-01 10:15:0'), [500, 800]);
        $this->stackOrder[] = new Pizza(new \DateTime('2018-12-01 10:40:0'), [300, 200]);
        $this->stackOrder[] = new Pizza(new \DateTime('2018-12-01 10:48:0'), [300, 800]); 
        $this->config(); 
    }

    private function config(){
        $this->stackOrder->rewind();
        while($this->stackOrder->valid()){
            $s =  $this->stackOrder->current();
            $s->status();
            $hotpizza = $this->oven->require($s);
            $delivpizza = $this->deliv->require($hotpizza);
            print('<br>');
            $this->stackOrder->next();
        }
    }
}
?>