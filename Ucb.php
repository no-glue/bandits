<?php

namespace bandits;

class Ucb{
	public function __construct(
		$counts=array(),
		$values=array()
	){
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
		$count=$arms=count($this->counts);

		while(--$arms){
			if(!$this->counts[$arms]){
				return $arms;
			}
		}

		$arms=$count;

		$ucbValues=array_pad(array(),$arms,0);

		$sum=array_sum($this->counts);

		while(--$arms){
			$bonus=pow(2*log($sum)/$this->counts[$arms],2);

			$ucbValues[$arms]=$this->values[$arms]+$bonus;
		}

		return array_search(max($ucbValues),$ucbValues);
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
