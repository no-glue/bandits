<?php

namespace bandits;

class TestVo{
	public $algorithm;

	public $arms;

	public $numSims;

	public $horizon;

	public function __construct(){}

	public function setup(
		$algorithm,
		$arms=7,
		$numSims=250,
		$horizon=250
	){
		$this->algorithm=new $algorithm;
		$this->arms=$arms;
		$this->numSims=$numSims;
		$this->horizon=$horizon;
	}
}
