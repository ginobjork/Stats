<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class LineupSummary extends Lineup
{
	public function getFunctionLabel() {
		return 'Summary';
	}
	
	public function getAltFunctionLabel() {
		return 'Rotation';
	}
	
	public function getData() {
		$lineups = parent::getData();
		ArrayHelper::multisort($lineups, 'PLAYERS');
		
		$summaryLineups = NULL;
		
		$lineupDesc = NULL;
		$currentLineup = NULL;
		foreach($lineups as $lineup) {
			//Yii::trace(print_r($lineup, TRUE));
			if($lineupDesc == NULL || $lineupDesc != $lineup['PLAYERS']) {
				if($lineupDesc != NULL) {
					// delete meaningless start & end time and period
					$currentLineup['START_TIME'] = "";
					$currentLineup['PERIOD_START'] = "";
					$currentLineup['END_TIME'] = "";
					$currentLineup['PERIOD_END'] = "";
					
					// format played time
					$currentLineup['PLAY_TIME_STR'] = $this->formatTime($currentLineup['PLAY_TIME']);

					$summaryLineups[] = $currentLineup;
				}
				
				$lineupDesc = $lineup['PLAYERS'];
				$currentLineup = $lineup;
			} else {
				$currentLineup['PLAY_TIME'] += $lineup['PLAY_TIME'];
				$currentLineup['POINTS_FOR'] += $lineup['POINTS_FOR'];
				$currentLineup['POINTS_AGST'] += $lineup['POINTS_AGST'];
				$currentLineup['REBOUNDS'] += $lineup['REBOUNDS'];
				$currentLineup['ASSISTS'] += $lineup['ASSISTS'];
				$currentLineup['TURNOVERS'] += $lineup['TURNOVERS'];
				$currentLineup['STEALS'] += $lineup['STEALS'];
				
				//Yii::trace($currentLineup['PLAY_TIME'] . ' ' . $lineup['PLAY_TIME']);
			}
		}
		
		return $summaryLineups;
	}
}
