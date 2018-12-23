<?php 
namespace PD\order;

class Invoice{
	private $id = [];
	private $timeArr = [];

	public function add($id, $time){
		$this->timeArr[] = clone $time;
		$this->id[] = $id;
	}

	public function status(){
		$str = '';
		for($i = 0; $i<count($this->id); $i++){
			$str .= $this->id[$i]."\t".$this->timeArr[$i]->format('H:i:s')."\t";
		}
		return $str."\n";
	}
}
?>