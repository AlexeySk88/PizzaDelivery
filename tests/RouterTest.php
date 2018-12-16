<?php 

use PHPUnit\Framework\TestCase;
use PD\order\Cook;
use PD\service\Router;

class RoutTest extends TestCase
{
	private $router;
	private $mock1;
	private $mock2;
	private $mock3;

	public function setUp(){
		$this->mock1 = $this->createmock('PD\order\Cook');
        $this->mock1->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock1->method('getAddress')->will($this->returnValue(array(400,500)));

        $this->mock2 = $this->createmock('PD\order\Cook');
        $this->mock2->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock2->method('getAddress')->will($this->returnValue(array(300,400)));

        $this->mock3 = $this->createmock('PD\order\Cook');
        $this->mock3->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock3->method('getAddress')->will($this->returnValue(array(700,900)));
		$this->router = new Router();
	}

	public function tearDown(){
		$this->router = NULL;
		unset($this->mock1);
		unset($this->mock2);
		unset($this->mock3);
	}

	public function testStart(){
		$arr = array($this->mock1, $this->mock2, $this->mock3);
        $res = $this->router->start($arr); 
        $this->assertSame($arr,$res);
	}

	public function matrixProvider(){
		$this->mock1 = $this->createmock('PD\order\Cook');
        $this->mock1->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock1->method('getAddress')->will($this->returnValue(array(400,500)));

        $this->mock2 = $this->createmock('PD\order\Cook');
        $this->mock2->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock2->method('getAddress')->will($this->returnValue(array(300,400)));

        $this->mock3 = $this->createmock('PD\order\Cook');
        $this->mock3->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock3->method('getAddress')->will($this->returnValue(array(700,900)));

		$line1 = [PHP_INT_MAX, 640, 500, 1140];
		$line2 = [640, PHP_INT_MAX, 141, 500];
		$line3 = [500, 141, PHP_INT_MAX, 640];
		$line4 = [1140, 500, 640, PHP_INT_MAX];

		return [
			[array($this->mock1), [
							array($line1[0], $line1[1]),
							array($line2[0], $line2[1])]
						],
			[array($this->mock1, $this->mock2), [
										array($line1[0],$line1[1], $line1[2]),
										array($line2[0], $line2[1], $line2[2]),
										array($line3[0], $line3[1], $line3[2])]
						],
			[array($this->mock1, $this->mock2, $this->mock3), array($line1, $line2, $line3, $line4)]
		];
	}

	/**
	*@dataProvider matrixProvider
	*/
	public function testMatrix($arr, $expected){
		$res = $this->router->matrix($arr, new \DateTime('2018-12-01 10:0:0'));
		$this->assertSame($res, $expected);
	}

	public function tablePdovider(){
		$line1 = [PHP_INT_MAX, 640, 500, 1140];
		$line2 = [640, PHP_INT_MAX, 141, 500];
		$line3 = [500, 141, PHP_INT_MAX, 640];
		$line4 = [1140, 500, 640, PHP_INT_MAX];

		return [
			[[1=>640], [[$line1[0], $line1[1]], [$line2[0], $line2[1]]]],
			[[2=>500, 1=>141], [
										[$line1[0],$line1[1], $line1[2]], 
										[$line2[0], $line2[1], $line2[2]],
										[$line3[0], $line3[1], $line3[2]]]
						],
			[[2=>500, 1=>141, 3=>500], [$line1, $line2, $line3, $line4]]
		];
	}


	/**
	*@dataProvider tablePdovider
	*/
	public function testMatrixInTable($expected, $matr){
		$res = $this->router->matrixInTable($matr);
		$this->assertSame($res, $expected);
	}

	public function checkTimeProvider(){
		$this->mock1 = $this->createmock('PD\order\Cook');
        $this->mock1->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock1->method('getAddress')->will($this->returnValue([400,500]));

        $this->mock2 = $this->createmock('PD\order\Cook');
        $this->mock2->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock2->method('getAddress')->will($this->returnValue([300,400]));

        $this->mock3 = $this->createmock('PD\order\Cook');
        $this->mock3->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
        $this->mock3->method('getAddress')->will($this->returnValue([700,900]));
		return [
			[[$this->mock1], [1=>640], ['10:10:40']],
			[[$this->mock1, $this->mock2], [2=>500, 1=>141], ['10:08:20','10:10:41']],
			[[$this->mock1, $this->mock2, $this->mock3], [2=>500, 1=>141, 3=>500], ['10:08:20','10:10:41',
				'10:19:01']]
		];
	}

	/**
	*@dataProvider checkTimeProvider()
	*/
	public function testCheckTime($prod, $table, $expected){

		$res = $this->router->checkTime($prod, $table, new \DateTime('2018-12-01 10:0:0'));
		$this->assertSame($res, $expected);
	}


	/*
		0	0
		400	500
		300	400
		700	900

		0 		640.3	500.0	1140.2
		640.3	0		141.4	500
		500		141.4	0		640.3
		1140.2	500		640.3	0

		0		10.40	8.20	19.0
		10.40	0		2.21	8.20
		8.20	2.21	0		10.40
		19.0	8.20	10.40	0
*/
}

?>