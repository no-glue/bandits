<?php

namespace bandits;

class TestAlgorithm{
	public function testAlgorithm(
		$algorithm='',
		$arms='',
		$numSums=0,
		$horizon=0
	){
		$algorithm=new $algorithm;

				

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
			$sumNums,
			$times,
			$chosenArms,
			$rewards,
			$cumulativeRewards
		);
	}
}
