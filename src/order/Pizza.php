<?php 

namespace PD\order;

use PD\iface\Product;

class Pizza implements Product{
	private static $counter = 1;
	private $id;
	protected $address;
	protected $cookPeriod;
	protected $orderTime;

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
		return '<'.$this->id.'>< '.$this->orderTime->format('H:i:s').'>';
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