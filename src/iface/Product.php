<?php 

namespace PD\iface;

interface Product{
	public function getInterval(\DateTime $date);
	public function setTime(\DateTime $time);
	public function status(): string;
	public function getTime(): \DateTime;
	public function cookPeriod();
}
?>