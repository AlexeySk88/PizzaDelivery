<?php 

use PHPUnit\Framework\TestCase;
use PD\order\Pizza;
use PD\service\Router;
use PD\service\Oven;

class RoutCheckTimeTest extends TestCase
{
	private $oven;
	private $router;

	public function checkTimeProvider(){
		$this->oven = new Oven();
		$prod1 = new Pizza(new \DateTime('2018-12-01 10:0:0'), [400, 500]);
		$cook1 = $this->oven->require($prod1);

		$prod2 = new Pizza(new \DateTime('2018-12-01 10:0:0'), [300, 400]);
		$cook2 = $this->oven->require($prod2);	

		$prod3 = new Pizza(new \DateTime('2018-12-01 10:0:0'), [700, 900]);
		$cook3 = $this->oven->require($prod3);

		return [
			[[$cook1], [1=>640], ['10:10:40']]
		];
	}

	/**
	*@dataProvider checkTimeProvider()
	*/
	public function testCheckTime($prod, $table, $expected){
		$this->router = new Router();
		$res = [];
		$arr = $this->router->checkTime($prod, $table, new \DateTime('2018-12-01 10:0:0'));
		foreach ($arr as $value) {
			$res[] = $value->getTime()->format('H:i:s');
		}
		$this->assertSame($res, $expected);
	}
}
?>