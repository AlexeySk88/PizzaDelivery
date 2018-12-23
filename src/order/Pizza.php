<?php 

namespace PD\order;

use PD\iface\Product;

class Pizza implements Product{
	private static $counter = 1;
	private $id;
	private $address;
	private $cookPeriod;
	private $orderTime;

	public function __construct(\DateTime $orderTime, $address){
		$this->id = self::$counter++;
		$this->address = $address;
		$this->orderTime = $orderTime;
		$this->cookPeriod = rand(10, 30);
	}

	public function __get($name){
		return $this->$name;
	}

	public function setTime(\DateTime $time){
		$this->orderTime = clone $time;
	}

	public function getInterval(\DateTime $date){
		$i = $this->orderTime->diff($date);
		$minutes = $i->i + $i->h*60 + $i->d*1440;
		return $minutes;
	}

	public function getTime(): \DateTime{
		return clone $this->orderTime;
	}

	public function status():string {
		return $this->id."\t".$this->orderTime->format('H:i:s')."\t";
		//return $this->id."\t".$this->orderTime->format('H:i:s')."\t".$this->cookPeriod;
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