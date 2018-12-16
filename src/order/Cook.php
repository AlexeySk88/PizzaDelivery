<?php 

namespace PD\order;

use PD\order\Decorator;


class Cook extends Decorator{
	protected $cookTime;

	public function setTime(\DateTime $time){
		$this->cookTime = $time;
	}

	public function getTime(): \DateTime{
		return $this->cookTime;
	}

	public function status(){
		print(' Время приготовления '.$this->cookTime->format(parent::date_format()));
	}
}
?>