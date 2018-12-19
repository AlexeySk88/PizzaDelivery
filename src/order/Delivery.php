<?php 
namespace PD\order;

use PD\order\Decorator;

class Delivery extends Decorator{
	protected $delivTime;

	public function setTime(\DateTime $time){
		$this->delivTime = $time;
	}

	public function getTime(): \DateTime{
		return $this->delivTime;
	}

	public function status(): string {
		$p = parent::getProduct();
		if(isset($p->product)) $p->status();
		$arr = parent::getAddress();
		return '<'.$arr[0].'><'.$arr[1].'><br>';
	}
}

?>
