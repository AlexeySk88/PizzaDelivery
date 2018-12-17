<?php
use PHPUnit\Framework\TestCase;
use PD\order\Cook;
use PD\oreder\Delivery;
use PD\service\Router;

class RouterRequireTest extends TestCase{
	private $rout;

	public function setUp(){
		$this->rout = new Router();
	}

	public function tearDown(){
		$this->rout = null;
	}

	public function testGeneral(){
		$cook1 = $this->createmock('PD\order\Cook');
        $cook1->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $cook1->method('getAddress')->will($this->returnValue(array(400,500)));
        $cook1->method('getInterval')->will($this->returnValue('10'));
        $res = $this->rout->require($cook1);
        $this->assertSame($res->getTime()->format('H:i:s'), '10:10:40');
	}

	public function Provider(){
		$cook1 = $this->createmock('PD\order\Cook');
        $cook1->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $cook1->method('getAddress')->will($this->returnValue(array(400,500)));

		$cook2 = $this->createmock('PD\order\Cook');
		$cook2->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
		$cook2->method('getAddress')->will($this->returnValue(array(300,400)));

		$cook3 = $this->createmock('PD\order\Cook');
		$cook3->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $cook3->method('getAddress')->will($this->returnValue(array(700,900)));

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