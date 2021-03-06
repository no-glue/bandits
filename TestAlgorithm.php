<?php

namespace bandits;

class TestAlgorithm{
	public function testAlgorithm(
		$instream,
		$namespace='\\bandits\\'
	){
		$algorithm=$namespace.trim(
			fgets(
				$instream
			)
		);

		$algorithm=new $algorithm;

		$probabilities=trim(
			fgets(
				$instream
			)
		);
		
		$probabilities=explode(
			',',
			$probabilities
		);

		$arms=array();

		$arm=$namespace.trim(
			fgets(
				$instream
			)
		);

		foreach($probabilities as $probability){
			$arms[]=new $arm(
				$probability
			);
		}

		$numSims=(int)trim(
			fgets(
				$instream
			)
		);

		$horizon=(int)trim(
			fgets(
				$instream
			)
		);

		$width=$numSims*$horizon;

		$chosenArms=array_pad(
			array(),
			$width,
			0
		);
		$rewards=array_pad(
			array(),
			$width,
			0
		);
		$cumulativeRewards=array_pad(
			array(),
			$width,
			0
		);
		$simNums=array_pad(
			array(),
			$width,
			0
		);
		$times=array_pad(
			array(),
			$width,
			0
		);

		for($i=0;$i<$numSims;$i++){
			$algorithm->initialize(
				count(
					$arms
				)
			);

			for($j=0;$j<$horizon;$j++){
				$index=$i*$horizon+$j;

				$simNums[$index]=$i;
				$times[$index]=$j;

				$chosenArm=$algorithm->selectArm();
				$chosenArms[$index]=$chosenArm;

				$reward=$arms[$chosenArms[$index]]->draw();
				$rewards[$index]=$reward;

				$cumulativeRewards[$index]=($index)?
					$cumulativeRewards[$index-1]+$reward:
					$reward;
			}

			$algorithm->update(
				$chosenArm,
				$reward
			);
		}

		$file=trim(
			fgets(
				$instream
			)
		);

		$key=trim(
			fgets(
				$instream
			)
		);

		return array(
			'instream'=>$instream,
			'callback'=>function(
				$array,
				$for='w'
				) use (
					$file,
					$key
				){
				$handle=fopen(
					$file,
					$for
				);

				fwrite(
					$handle,
					is_array($array[$key])?
					implode(
						',',
						$array[$key]
					):
					$array[$key]
				);

				fclose($handle);
			},
			'simNums'=>$simNums,
			'times'=>$times,
			'chosenArms'=>$chosenArms,
			'rewards'=>$rewards,
			'cumulativeRewards'=>$cumulativeRewards
		);
	}
}
