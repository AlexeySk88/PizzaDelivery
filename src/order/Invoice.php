<?php 
namespace PD\order;

class Invoce{
	private $id;
	private $delivTime;

	public function __construct($id, $time){
		$this->id = $id;
		$this->delivTime = $time;
	}

	public function __toString(){
		return '<'.$this->id.'><'.$this->delivTime.'><br>';
	}
}
?>