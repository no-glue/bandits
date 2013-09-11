<?php

namespace bandits;

class ZeroOneArm{
	protected $probability;

	public function __construct($probability=0.3){
		$this->probability=$probability;
	}

	public function setProbability($probability){
		$this->probability=$probability;

		return $this;
	}

	public function getProbability(){
		return $this->probability;
	}

	public function draw(){
		return (($rand=mt_rand()/mt_getrandmax()) && 
			$rand>$this->probability)?0:1;
	}
}
