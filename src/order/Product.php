<?php 

namespace PD\order;

interface Product{
	public function getInterval(\DateTime $date);
	public function setTime(\DateTime $time);
	public function getTime(): \DateTime;
	public function status();
	public function cookPeriod();
}
?>