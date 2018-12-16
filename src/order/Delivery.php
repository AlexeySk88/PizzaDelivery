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

	public function status(){
		print(' Время доставки '.$this->delivTime->format(parent::date_format()));
	}
}

?>
