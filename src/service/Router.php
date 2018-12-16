<?php 

namespace PD\service;

use PD\service\Service;
use PD\order\Product;
use PD\order\Delivery;


class Router implements Service{
	private $delivMan = [];
	private const MAXDELIV = 3;
	private const MAXTIME = 60;
	private $startTime;
	private $num = 1;

	public function require(Product $prod){
		/*if(count($this->delivMan) == self::MAXDELIV) $this->start($this->delivMan);
		$this->startTime = $prod->getTime() > $this->startTime ? $prod->getTime() : $this->startTime;
		$deliv = new Delivery($prod);
		$this->delivMan[] = $deliv;
		if($this->matrix($this->startTime)){
			foreach ($this->delivMan as $man) {
				$man->status();
			}
			return false;
		}
		$this->start($this->delivMan);*/
		$this->matrix($this->delivMan, $prod->getTime());
	}

	public function matrix(array $prods, \DateTime $time){  //private
		$routMatrix = [];
		$arr[0] = array(0, 0);
		foreach ($prods as $p) {
			$p->setTime($time);
			$arr[] = $p->getAddress();
		}
		for($i = 0; $i < count($arr); $i++){
			for($j = 0; $j < count($arr); $j++){
				$res=intval(sqrt(($arr[$i][0] - $arr[$j][0])**2 + ($arr[$i][1] - $arr[$j][1])**2));
				$routMatrix[$i][$j] = $res == 0 ? PHP_INT_MAX : $res;
			}
		}
		/*if(count($this->delivMan) == 1) {
			$time->modify('+ '.$routMatrix[0][1].'second');
			$this->delivMan[0]->setTime($time);
			return true;
		}*/
		/*for($i = 0; $i < count($routMatrix); $i++){
			print('<br>');
			for($j = 0; $j< count($routMatrix); $j++){
				print($routMatrix[$i][$j].' | ');
			}
		}*/
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

	public function checkTime(array $prod, array $table, \DateTime $time){  //private
		$finishRouts = [];
		foreach ($table as $key => $value) {
			$time->modify('+ '.$value.' second');
			$rout = $prod[$key-1]->setTime($time);
/*			if($rout->getTime > self::MAXTIME){
				$this->routMatrix[$key] = PHP_INT_MAX;
				return $this->matrixInTable();
			}*/
			$finishRouts[] = $time->format('H:i:s');
		}
		return $finishRouts;
	}

	public function start(array $prod){ //private
		$this->delivMan = [];
		$this->num++;
		return $prod;
	}
}

?>