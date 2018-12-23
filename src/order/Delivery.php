<?php 
namespace PD\order;

use PD\order\Decorator;

class Delivery extends Decorator{
	private $delivTime;

	public function setTime(\DateTime $time){
		$this->delivTime = clone $time;
	}

	public function getTime(): \DateTime{
		return clone $this->delivTime;
	}

	public function status(): string {
		$p = parent::getProduct();
		$arr = parent::getAddress();
		return $p->status()."\t".$arr[0]."\t".$arr[1];
	}
}

?>
