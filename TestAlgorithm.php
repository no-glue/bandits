<?php

namespace bandits;

class TestAlgorithm{
	public function testAlgorithm(
		$instream
	){
		$algorithm=fgets($instream);

		$algorithm=new $algorithm;

		$probabilities=fgets($instream);
		
		$probabilities=explode(',',$probabilities);

		$arms=array();

		foreach($probabilities as $probability){
			$arms=new \bandits\ZeroOneArm(
				$probability
			);
		}

		$numSims=(int)fgets($instream);

		$horizon=(int)fgets($instream);

		$width=$numSims*$horizon;

		$chosenArms=range(0,$width,0);
		$rewards=range(0,$width,0);
		$cumulativeRewards=range(0,$width,0);
		$simNums=range(0,$width,0);
		$times=range(0,$width,0);

		for($i=0;$i<$numSims;$i++){
			$algorithm->initialize(count($arms));

			for($j=0;$j<$horizon;$j++){
				$index=$i*$horizon+$j;

				$sumNums[$index]=$i;
				$times[$index]=$j;

				$chosenArm=$algorithm->selectArm();
				$chosenArms[$index]=$chosenArm;

				$reward=$arms[$chosenArms[$index]]->draw();
				$rewards[$index]=$reward;

				$cumulativeRewards=($j)?
					$cumulativeRewards+$reward:
					$reward;
			}

			$algorithm->update($chosenArm,$reward);
		}

		return array(
			$instream,
			$sumNums,
			$times,
			$chosenArms,
			$rewards,
			$cumulativeRewards,
			$instream
		);
	}
}
