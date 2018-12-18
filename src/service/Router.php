<?php 

namespace PD\service;

use PD\iface\Service;
use PD\iface\Product;
use PD\iface\Waylbill;
use PD\order\Invoice;
use PD\order\Delivery;


class Router implements Service, Waylbill{
	private $prodArr = [];
	private $routArr = [];
	private $matrixDeliv = [];
	private const MAXDELIV = 3;
	private const MAXTIME = 60;
	private $startTime;
	private $num = 1;

	public function require(Product $prod){
		if(count($this->prodArr) == self::MAXDELIV){
			$this->prodArr = [];
			$this->num++;
			$this->startTime = null;
		}
		$this->startTime = $prod->getTime() > $this->startTime ? $prod->getTime() : $this->startTime;
		$this->prodArr[] = $prod;
		$this->matrixDeliv = $this->prodInMatrix($this->prodArr);
		$tableDeliv = $this->matrixInTable($this->matrixDeliv);
		if(!$tableDeliv){
			$this->prodArr = [];
			$this->num++;
			$this->startTime = null;
			return $this->require($prod);			
		}
		$this->routArr = $res = $this->checkTime($this->prodArr, $tableDeliv, $this->startTime);
		return $res;
	}

	public function prodInMatrix(array $prods){  //private
		$routMatrix = [];
		$arr[0] = array(0, 0);
		foreach ($prods as $p) {
			$arr[] = $p->getAddress();
		}
		for($i = 0; $i < count($arr); $i++){
			for($j = 0; $j < count($arr); $j++){
				$res=intval(sqrt(($arr[$i][0] - $arr[$j][0])**2 + ($arr[$i][1] - $arr[$j][1])**2));
				$routMatrix[$i][$j] = $res == 0 ? PHP_INT_MAX : $res;
			}
		}
		return $routMatrix;
	}

	public function matrixInTable(array $matr){  //private
		$routTable = [];
		$index = 0;
		for($i = 0; $i < count($matr)-1; $i++){
			$var = min($matr[$index]);
			if($var == PHP_INT_MAX) return false;
			$checkKey = array_search($var, $matr[$index]);
			if(array_key_exists($checkKey, $routTable) || $checkKey == 0) {
				$matr[$index][$checkKey] = PHP_INT_MAX;
				$i--;
			}
			else {
				$index = $checkKey;
				$routTable[$index] = $var;	
			}	
		}
		return $routTable;		
	}

	public function checkTime(array $prods, array $table, \DateTime $time){  //private
		foreach ($table as $key => $value) {
			$time->modify('+ '.$value.' second');
			$prod = $prods[$key-1];
			if($prod->getInterval($time) >= self::MAXTIME){
				$index = array_keys($this->matrixDeliv[$key], min($this->matrixDeliv[$key]));
				$this->matrixDeliv[$key][$index] = PHP_INT_MAX;
				return $this->matrixInTable($this->matrixDeliv);
			}
			$rout = new Delivery($prod);
			$rout->setTime(clone $time);
			$prods[$key-1] = $rout;
		}
		return $prods;
	}

	public function getOrder(){
		usort($this->routArr, 'cmp');

		foreach ($this->routArr as $value) {
			
		}
	}

	private function cmp($a, $b){
		$at = $a->getTime();
		$bt = $b->getTime();
		if ($at == $bt) {
	        return 0;
	    }
	    return ($at < $bt) ? -1 : 1;
	}
}

?>