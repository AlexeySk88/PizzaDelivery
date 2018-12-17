<?php
use PHPUnit\Framework\TestCase;
use PD\order\Pizza;
use PD\service\Router;
use PD\service\Oven;

class RouterRequireTest extends TestCase{
	private $rout;
    private $oven;

        public function tearDown(){
        $this->oven = NULL;
        $this->rout = NULL;
    }

	public function Provider(){
        $this->oven = new Oven();
        $prod1 = new Pizza(new \DateTime('2018-12-01 10:0:0'), [400, 500]);
        $cook1 = $this->oven->require($prod1);

        $prod2 = new Pizza(new \DateTime('2018-12-01 10:0:0'), [300, 400]);
        $cook2 = $this->oven->require($prod2);  

        $prod3 = new Pizza(new \DateTime('2018-12-01 10:0:0'), [700, 900]);
        $cook3 = $this->oven->require($prod3);

        $expect1 = ['10:10:40'];
        $expect2 = ['10:08:20','10:10:41'];
        $expect3 = ['10:08:20','10:10:41','10:19:01'];

        return [
        	[[$cook1], $expect1],
        	[[$cook1, $cook2], $expect2],
        	[[$cook1, $cook2, $cook3], $expect3]
        ];
    }

    /**
    *@dataProvider Provider
    */
    public function testRequire($arr, $expect){
        $this->rout = new Router();
    	$res = [];
    	foreach ($arr as $cook) {
 			$res = $this->rout->require($cook);
 		}
        foreach ($res as $key => $value) {
         	$this->assertSame($value->getTime()->format('H:i:s'), $expect[$key]);
        }        	
    }
}

?>