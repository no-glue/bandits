<?php

namespace bandits;

class Greedy{
	public function __construct(
		$probability=0.3,
		$counts=array(),
		$values=array()
	){
		$this->probability=$probability;
		$this->counts=$counts;
		$this->values=$values;
	}

	public function initialize($narms){
		$this->counts=array_pad(
			$this->counts,
			$narms,
			0
		);

		$this->values=array_pad(
			$this->values,
			$narms,
			0
		);
	}

	public function selectArm(){
		return ((mt_rand()/mt_getrandmax())>$this->probability)?
			array_search(
				max(
					$this->values
				),
				$this->values
			):
			array_rand(
				$this->values
			);
	}

	public function update(
		$chosenArm,
		$reward
	){
		$this->counts[$chosenArm]+=1;
		
		$n=$this->counts[$chosenArm];

		$value=$this->values[$chosenArm];

		$newValue=(($n-1)/(float)$n)*$value+
			(1/(float)$n)*$reward;

		$this->values[$chosenArm]=$newValue;	
	}
}
