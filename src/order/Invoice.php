<?php 
namespace PD\order;

class Invoice{
	private $id;
	private $timeArr = [];

	public function __construct($id){
		$this->id = $id;
	}

	public function add($time){
		$this->timeArr[] = $time;
	}

	public function toConsole(){
		$str = '';
		foreach ($this->timeArr as $time) {
			$str .= '<'.$this->id.'><'.$time->format('H:i:s').'>';
		}
		echo("console.log(".$str.");");
	}
}
?>