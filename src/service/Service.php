<?php 
namespace PD\service;

use PD\order\Product;

interface Service{
	public function require(Product $prod);
}
?>