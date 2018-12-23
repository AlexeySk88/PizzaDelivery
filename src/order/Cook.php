<?php 

namespace PD\order;

use PD\order\Decorator;


class Cook extends Decorator{
	private $cookTime;

	public function setTime(\DateTime $time){
		$this->cookTime = clone $time;
	}

	public function getTime(): \DateTime{
		return clone $this->cookTime;
	}

	public function status(): string {
		$p = parent::getProduct();
		return $p->status()."\t".$this->cookTime->format('H:i:s');
	}
}
?>