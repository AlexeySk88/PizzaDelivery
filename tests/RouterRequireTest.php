<?php
use PHPUnit\Framework\TestCase;
use PD\order\Cook;
use PD\service\Router;
use PD\service\Oven;

class RouterRequireTest extends TestCase{
	private $rout;
    private $oven;
    private $cook1;
    private $cook2;
    private $cook3;
    private $cook4;

        public function tearDown(){
        $this->oven = NULL;
        $this->rout = NULL;
    }

	public function Provider(){
        $this->cook1 = $this->createmock('PD\order\Cook');
        $this->cook1->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->cook1->method('getAddress')->will($this->returnValue(array(400,500)));
        $this->cook1->method('getInterval')->will($this->returnValue(10));

        $this->cook2 = $this->createmock('PD\order\Cook');
        $this->cook2->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->cook2->method('getAddress')->will($this->returnValue(array(300,400)));
        $this->cook2->method('getInterval')->will($this->returnValue(10));

        $this->cook3 = $this->createmock('PD\order\Cook');
        $this->cook3->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->cook3->method('getAddress')->will($this->returnValue(array(700,900)));
        $this->cook3->method('getInterval')->will($this->returnValue(10));

        $this->cook4 = $this->createmock('PD\order\Cook');
        $this->cook4->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 11:20:0')));
        $this->cook4->method('getAddress')->will($this->returnValue(array(400,500)));
        $this->cook4->method('getInterval')->will($this->returnValue(10));

        $expect1 = ['10:10:40'];
        $expect2 = ['10:08:20','10:10:41'];
        $expect3 = ['10:19:00','10:08:20','10:10:41'];
        $expect4 = ['11:30:40'];

        return [
        	[$this->cook1, $expect1],
        	[$this->cook2, $expect2],
        	[$this->cook3, $expect3],
            [$this->cook4, $expect4]
        ];
    }

    /**
    *@dataProvider Provider
    */
    public function testRequire($prod, $expect){
        $this->rout = new Router();
    	$res = [];
 			$res = $this->rout->require($prod);
        foreach ($res as $key => $value) {
         	$this->assertSame($value->getTime()->format('H:i:s'), $expect[$key]);
        }        	
    }
}

?>