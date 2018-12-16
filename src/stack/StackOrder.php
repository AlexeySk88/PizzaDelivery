<?php 
namespace PD\stack;

use PD\order\Product;

interface Stack{
	public function push(Product $product);
	public function peek();
}

class StackOrder implements Stack, \Iterator{
	private $component = [];
	private $index = 0;

	public function push(Product $product){
		$this->component[] = $product;
	}

	public function peek(){
		if(count($this->component) > 0){
			$comp = $this->component[$this->index++];
			array_shift($this->component);
			return $comp;		
		}
		else return null;
	}

	public function rewind(){
		$this->index = 0;
	}

	public function key(){
		return $this->index;
	}

	public function current(){
		return $this->component[$this->index];
	}

	public function next(){
		++$this->index;
	}

	public function valid(){
		return isset($this->component[$this->index]);
	}

	public function print(){
		foreach ($this->component as $comp) {
			print("<div>".$comp->cookTime."</div>");
			print("<div>OrderTime: ".$comp->orderTime."</div>");
		}
	}
}
?>