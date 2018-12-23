<?php 

namespace PD\order;

use PD\iface\Product;


abstract class Decorator implements Product{
	protected $prod = null;
	
	public function __construct(Product $prod){
		$this->prod = $prod;
	}

	protected function getProduct(){
		return $this->prod;
	}

	protected function date_format(){
		return 'H:i:s';
	}

	public function getInterval(\DateTime $date){
		$p = self::getProduct();
		if(!isset($p->orderTime)) return $p->getInterval($date);
		return $p->getInterval($date);
	}

	public function getAddress(){
		$p = self::getProduct();
		if(!isset($p->address)) return $p->getAddress();
		return $p->address;
	}

	public function getId(){
		$p = self::getProduct();
		if(!isset($p->id)) return $p->getId();
		return $p->id;
	}

	public function cookPeriod(){
		$p = self::getProduct();
		if(!isset($p->cookPeriod)) return $p->cookPeriod();
		return $p->cookPeriod;
	}

	abstract public function status(): string;
	abstract public function setTime(\DateTime $time);
	abstract public function getTime(): \DateTime;
}
?>