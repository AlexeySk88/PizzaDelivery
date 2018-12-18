<?php 
namespace PD\iface;

use PD\order\Product;

interface Service{
	public function require(Product $prod);
}
?>