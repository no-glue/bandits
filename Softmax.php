<?php

namespace bandits;

class Softmax{
	public function __construct(
		$temperature=0.3,
		$counts=array(),
		$values=array()
	){
		$this->temperature=$temperature;
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
		$sum=exp(
			array_sum(
				$this->values
			)
			/
			$this->temperature
		);

		$probabilities=array();

		foreach($this->values as $value){
			$probabilities[]=exp(
				$value
				/
				$this->temperature
			)
			/
			$sum;
		}

		$random=mt_rand();

		$cumulativeProbability=0;

		$i=0;

		while(
			($cumulativeProbability+=array_shift($probabilities))
			<=
			$random 
			&&
			count($probabilities)
			&&
			++$i
		){
		}

		return $i;
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
