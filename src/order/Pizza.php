<?php 

namespace PD\order;

use PD\order\Product;

class Pizza implements Product{
	protected $address;
	protected $cookPeriod;
	protected $orderTime;

	public function __construct(\DateTime $orderTime, $address){
		if(is_array($address)) {
			$this->address = $address;
			$this->orderTime = $orderTime;
			$this->cookPeriod = rand(10, 30);
		}
		else throw new Exception('Constructor of class Pizza: $address is not an array type');		// отдельный файл
	}

	public function __get($name){
		return $this->$name;
	}

	public function setTime(\DateTime $time){
		$this->orderTime = $time;
	}

	public function getInterval(\DateTime $date){
		$i = $this->orderTime->diff($date);
		$minutes = $i->i + $i->h*60 + $i->d*1440;
		return $minutes;
	}

	public function getTime(): \DateTime{
		return $this->orderTime;
	}

	public function status(){
		print('Время заказа '.$this->orderTime->format('Y-m-d H:i:s'));
	}

	public function __isset($name){
		if(isset($this->$name)) return $this->$name;
		return false;
	}

	public function cookPeriod(){
		return $this->cookPeriod;
	}
}
?>