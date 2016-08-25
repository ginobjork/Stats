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
	public function getFunctionLabel() {
		return 'Rotation';
	}
	
	public function getAltFunctionLabel() {
		return 'Summary';
	}

	public function attributeLabels() {
		return [
			'PLAYERS' => 'Lineup',
			'PERIOD_START' => 'SP',
			'START_TIME' => 'ST',
			'PERIOD_END' => 'EP',
			'END_TIME' => 'ET',
			'PLAY_TIME' => 'PT',
			'POINTS' => 'P',
			'POINTS_FOR' => 'PM',
			'POINTS_AGST' => 'PR',
			'REBOUNDS' => 'R',
			'TURNOVERS' => 'T',
			'STEALS' => 'S',
			'ASSISTS' => 'A',
		];
	}

	public function tooltips() {
		return [
			'PLAYERS' => 'Components Lineup',
			'PERIOD_START' => 'Start Period',
			'START_TIME' => 'Start Time',
			'PERIOD_END' => 'End Period',
			'END_TIME' => 'End Time',
			'PLAY_TIME' => 'Played Time',
			'POINTS' => 'Points Difference',
			'POINTS_FOR' => 'Points Made',
			'POINTS_AGST' => 'Points Received',
			'REBOUNDS' => 'Rebounds',
			'TURNOVERS' => 'Turnovers',
			'STEALS' => 'Steals',
			'ASSISTS' => 'Assists',
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
			p1.SURNAME as P1_SURNAME, p1.FIRST_NAME as P1_FIRST_NAME, pg1.SHIRT_NUMBER as P1_SHIRT_NUMBER, 
			p2.SURNAME as P2_SURNAME, p2.FIRST_NAME as P2_FIRST_NAME, pg2.SHIRT_NUMBER as P2_SHIRT_NUMBER, 
			p3.SURNAME as P3_SURNAME, p3.FIRST_NAME as P3_FIRST_NAME, pg3.SHIRT_NUMBER as P3_SHIRT_NUMBER, 
			p4.SURNAME as P4_SURNAME, p4.FIRST_NAME as P4_FIRST_NAME, pg4.SHIRT_NUMBER as P4_SHIRT_NUMBER, 
			p5.SURNAME as P5_SURNAME, p5.FIRST_NAME as P5_FIRST_NAME, pg5.SHIRT_NUMBER as P5_SHIRT_NUMBER,
			PERIOD_START,
			START_TIME,
			PERIOD_END,
			END_TIME, 
			PLAY_TIME, 
			POINTS_FOR, 
			POINTS_AGST, 
			REBOUNDS, 
			ASSISTS, 
			TURNOVERS, 
			STEALS 
			FROM MY_LINEUP l
			JOIN MY_PLAYER p1 ON l.PLAYER1 = p1.PLAYER_ID
			JOIN MY_PLAYER_GAME pg1 on l.PLAYER1 = pg1.PLAYER_ID and l.GAME_ID = pg1.GAME_ID
			JOIN MY_PLAYER p2 ON l.PLAYER2 = p2.PLAYER_ID
			JOIN MY_PLAYER_GAME pg2 on l.PLAYER2 = pg2.PLAYER_ID and l.GAME_ID = pg2.GAME_ID
			JOIN MY_PLAYER p3 ON l.PLAYER3 = p3.PLAYER_ID
			JOIN MY_PLAYER_GAME pg3 on l.PLAYER3 = pg3.PLAYER_ID and l.GAME_ID = pg3.GAME_ID
			JOIN MY_PLAYER p4 ON l.PLAYER4 = p4.PLAYER_ID
			JOIN MY_PLAYER_GAME pg4 on l.PLAYER4 = pg4.PLAYER_ID and l.GAME_ID = pg4.GAME_ID
			JOIN MY_PLAYER p5 ON l.PLAYER5 = p5.PLAYER_ID
			JOIN MY_PLAYER_GAME pg5 on l.PLAYER5 = pg5.PLAYER_ID and l.GAME_ID = pg5.GAME_ID
			WHERE l.TEAM_ID = :teamId and l.GAME_ID = :gameId
			ORDER BY PLAY_TIME DESC
EOT;
		$query = Yii::$app->db->createCommand($statement);
		$query->bindValue(':teamId', 1);
		$query->bindValue(':gameId', 1);
		$rows = $query->queryAll();

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
}
