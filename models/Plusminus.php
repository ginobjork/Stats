<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "MY_LINEUP".
 *
 */
class Lineup extends Model
{
	public function attributeLabels() {
		return [
			'SHIRT_NUMBER' => '#',
			'NAME' => 'Player', 
			'COURTTIMEON' => 'PT',
			'COURTTIMEOFF' => 'BT',
			'POINTSON' => 'P',
			'POINTSOFF' => 'P',
			'POINTSFORON' => 'PM',
			'POINTSFOROFF' => 'PM',
			'POINTSAGSTON' => 'PR',
			'POINTSAGSTOFF' => 'PR',
			'REBOUNDSON' => 'R',
			'REBOUNDSOFF' => 'R',
			'TURNOVERSON' => 'T',
			'TURNOVERSOFF' => 'T',
			'STEALSON' => 'S',
			'STEALSOFF' => 'S',
			'ASSISTSON' => 'A',
			'ASSISTSOFF' => 'A',
		];
	}

	public function tooltips() {
		return [
			'SHIRT_NUMBER' => 'Shirt Number',
			'NAME' => 'Player Name', 
			'COURTTIMEON' => 'Play Time',
			'COURTTIMEOFF' => 'Bench Time',
			'POINTSON' => 'Points Difference When Play',
			'POINTSOFF' => 'Points Difference On Bench',
			'POINTSFORON' => 'Points Made When Play',
			'POINTSFOROFF' => 'PM',
			'POINTSAGSTON' => 'PR',
			'POINTSAGSTOFF' => 'PR',
			'REBOUNDSON' => 'R',
			'REBOUNDSOFF' => 'R',
			'TURNOVERSON' => 'T',
			'TURNOVERSOFF' => 'T',
			'STEALSON' => 'S',
			'STEALSOFF' => 'S',
			'ASSISTSON' => 'A',
			'ASSISTSOFF' => 'A',
		];
	}

    public function getTooltips($attribute) {
		$labels=$this->tooltips();
		if(isset($labels[$attribute]))
			return $labels[$attribute];
		else
			return 'Not Set';
	}
	
	public function formatTime($decimalTime) {
		$playTime = $decimalTime;
		$dotPos = strpos($playTime, ".");
		$minutes = "0";
		if($dotPos > 0) {
			$minutes = substr($playTime, 0, $dotPos);
		}
		$seconds = (float) ('0' . substr($playTime, $dotPos, strlen($playTime) - $dotPos));
		$seconds = round(60 * $seconds, 0);
		return(sprintf('%02d:%02d', $minutes, $seconds));
	}
        	
    public function getData() 
    {
		$statement = <<<EOT
		SELECT 
			pg.SHIRT_NUMBER as SHIRT_NUMBER,
			p.SURNAME as SURNAME, 
			p.FIRST_NAME as FIRST_NAME, 
			IFNULL(COURTTIMEON, 0) as COURTTIMEON,
			IFNULL(COURTTIMEOFF, 0) as COURTTIMEOFF,
			IFNULL(POINTSON, 0) as POINTSON,
			IFNULL(POINTSOFF, 0) as POINTSOFF,
			IFNULL(POINTSFORON, 0) as POINTSFORON,
			IFNULL(POINTSFOROFF, 0) as POINTSFOROFF,
			IFNULL(POINTSAGSTON, 0) as POINTSAGSTON,
			IFNULL(POINTSAGSTOFF, 0) as POINTSAGSTOFF,
			IFNULL(REBOUNDSON, 0) as REBOUNDSON,
			IFNULL(REBOUNDSOFF, 0) as REBOUNDSOFF,
			IFNULL(TURNOVERSON, 0) as TURNOVERSON,
			IFNULL(TURNOVERSOFF, 0) as TURNOVERSOFF,
			IFNULL(STEALSON, 0) as STEALSON,
			IFNULL(STEALSOFF, 0) as STEALSOFF,
			IFNULL(ASSISTSON, 0) as ASSISTSON,
			IFNULL(ASSISTSOFF, 0) as ASSISTSOFF
		FROM 
		(
			SELECT 
			PLAYER_ID,
			GAME_ID,
			TEAM_ID,
			sum(COURTTIME) AS COURTTIMEON,
			sum(POINTS) AS POINTSON,
			sum(POINTSFOR) AS POINTSFORON,
			sum(POINTSAGST) AS POINTSAGSTON,
			sum(REBOUNDS) AS REBOUNDSON,
			sum(TURNOVERS) AS TURNOVERSON,
			sum(STEALS) AS STEALSON,
			sum(ASSISTS) AS ASSISTSON
			FROM MY_PLAYERPLUSMINUS
			WHERE ONCOURT = 1 AND COURTTIME > 0 AND TEAM_ID = :teamId AND GAME_ID = :gameId
			GROUP BY PLAYER_ID, GAME_ID, TEAM_ID
		) ONCOURT 
		LEFT JOIN
		(
			SELECT 
			PLAYER_ID,
			GAME_ID,
			TEAM_ID,
			sum(COURTTIME) AS COURTTIMEOFF,
			sum(POINTS) AS POINTSOFF,
			sum(POINTSFOR) AS POINTSFOROFF,
			sum(POINTSAGST) AS POINTSAGSTOFF,
			sum(REBOUNDS) AS REBOUNDSOFF,
			sum(TURNOVERS) AS TURNOVERSOFF,
			sum(STEALS) AS STEALSOFF,
			sum(ASSISTS) AS ASSISTSOFF
			FROM MY_PLAYERPLUSMINUS
			WHERE ONCOURT = 0 AND COURTTIME > 0 AND TEAM_ID = :teamId AND GAME_ID = :gameId
			GROUP BY PLAYER_ID, GAME_ID, TEAM_ID
		) OFFCOURT ON
			ONCOURT.PLAYER_ID = OFFCOURT.PLAYER_ID
		JOIN MY_PLAYER p 
			ON ONCOURT.PLAYER_ID = p.PLAYER_ID
		JOIN MY_PLAYER_GAME pg 
			ON ONCOURT.PLAYER_ID = pg.PLAYER_ID and ONCOURT.GAME_ID = pg.GAME_ID
		ORDER BY SHIRT_NUMBER
EOT;
		$query = Yii::$app->db->createCommand($statement);
		$query->bindValue(':teamId', 1);
		$query->bindValue(':gameId', 1);
		$rows = $query->queryAll();

////

		$count = 0;
		$lineups = NULL;
		foreach($rows as $row) {
			// build players description
			$numbers = NULL;
			$numbers[] = ['shirt' => $row['P1_SHIRT_NUMBER'], 'pos' => 1]; 
			$numbers[] = ['shirt' => $row['P2_SHIRT_NUMBER'], 'pos' => 2];  
			$numbers[] = ['shirt' => $row['P3_SHIRT_NUMBER'], 'pos' => 3];  
			$numbers[] = ['shirt' => $row['P4_SHIRT_NUMBER'], 'pos' => 4];  
			$numbers[] = ['shirt' => $row['P5_SHIRT_NUMBER'], 'pos' => 5];

			ArrayHelper::multisort($numbers, 'shirt');

			$players = "";
			for($i = 0; $i < count($numbers); ++$i) {
				if($i > 0) {
					$players .= '/ ';
				}
				$pos = $numbers[$i]['pos'];
				$players .= $row['P' . $pos . '_FIRST_NAME'] . ' ' . substr($row['P' . $pos . '_SURNAME'], 0, 1) . '.(' . $row['P' . $pos . '_SHIRT_NUMBER'] . ')';
			}
			
			$count += 1;
			
			// inject players description
			$row['PLAYERS'] = $players;
			
			// format played time
			$row['PLAY_TIME_STR'] = $this->formatTime($row['PLAY_TIME']);

			// calculate points difference
			$row['POINTS'] = $row['POINTS_FOR'] - $row['POINTS_AGST'];
			
			// delete hour from period time
			$row['START_TIME'] = substr($row['START_TIME'], 3, 5);
			$row['END_TIME'] = substr($row['END_TIME'], 3, 5);
			
			$lineups[] = $row;
		}
		
		return $lineups; 
    }

	public function getSummaryData() {
		$lineups = $this->getData();
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

					// calculate points difference
					$currentLineup['POINTS'] = $currentLineup['POINTS_FOR'] - $currentLineup['POINTS_AGST'];

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
