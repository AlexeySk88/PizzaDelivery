<?php 
namespace PD\iface;

use PD\iface\Product;

interface Service{
	public function require(Product $prod);
}
?>