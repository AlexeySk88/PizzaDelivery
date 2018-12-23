<?php 

namespace PD\service;

use PD\iface\Service;
use PD\iface\Product;
use PD\order\Cook;

class Oven implements Service{
	private $ovenArr = [0 => null, 1 => null];

	public function require(Product $prod){
		if(!$this->ovenArr) $this->ovenArr = [$prod->getTime(), clone $prod->getTime()];
		$index = $this->ovenArr[0] <= $this->ovenArr[1]? 0 : 1;
		$this->ovenArr[$index] = max($this->ovenArr[$index], $prod->getTime())->modify('+ '.$prod->cookPeriod().' minutes');
		$cook = new Cook($prod);
		$cook->setTime($this->ovenArr[$index]);
		$cook->status();
		return $cook;
	}
}

?>