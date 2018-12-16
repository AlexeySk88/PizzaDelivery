<?php

use PHPUnit\Framework\TestCase;
use PD\service\Oven;
use PD\order\Pizza;

class OvenTest extends TestCase
{
	private $oven;

	public function setUp(){
		$this->oven = new Oven();
	}

	public function tearDown(){
		$this->oven = NULL;
	}

	public function testOvenRequore(){
		$mock1 = $this->createMock('PD\order\Pizza');
		$mock1->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:0:0')));
		$mock1->method('cookPeriod')->will($this->returnValue(25));

		$mock2 = $this->createMock('PD\order\Pizza');
		$mock2->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:10:0')));
		$mock2->method('cookPeriod')->will($this->returnValue(20));

		$mock3 = $this->createMock('PD\order\Pizza');
		$mock3->method('getTime')->will($this->returnValue(new \DateTime('2018-12-01 10:17:0')));
		$mock3->method('cookPeriod')->will($this->returnValue(10));

		$this->assertSame($this->oven->require($mock1)->getTime()->format('H:i'), '10:25');
		$this->assertSame($this->oven->require($mock2)->getTime()->format('H:i'), '10:30');
		$this->assertSame($this->oven->require($mock3)->getTime()->format('H:i'), '10:35');
	}
}