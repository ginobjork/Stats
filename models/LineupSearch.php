<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lineup;

/**
 * LineupSearch represents the model behind the search form about `app\models\Lineup`.
 */
class LineupSearch extends Lineup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GAME_ID', 'TEAM_ID', 'PLAYER1', 'PLAYER2', 'PLAYER3', 'PLAYER4', 'PLAYER5', 'PERIOD_START', 'PERIOD_END', 'POINTS_FOR', 'POINTS_AGST', 'REBOUNDS', 'TURNOVERS', 'STEALS', 'ASSISTS'], 'integer'],
            [['START_TIME', 'END_TIME'], 'safe'],
            [['PLAY_TIME'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Lineup::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	    'pagination' => false,
	    'sort' => [
		'defaultOrder' => [
		    'PERIOD_START' => SORT_ASC,
		    'START_TIME' => SORT_DESC, 
		]
	    ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'GAME_ID' => $this->GAME_ID,
            'TEAM_ID' => $this->TEAM_ID,
            'PLAYER1' => $this->PLAYER1,
            'PLAYER2' => $this->PLAYER2,
            'PLAYER3' => $this->PLAYER3,
            'PLAYER4' => $this->PLAYER4,
            'PLAYER5' => $this->PLAYER5,
            'PERIOD_START' => $this->PERIOD_START,
            'START_TIME' => $this->START_TIME,
            'PERIOD_END' => $this->PERIOD_END,
            'END_TIME' => $this->END_TIME,
            'PLAY_TIME' => $this->PLAY_TIME,
            'POINTS_FOR' => $this->POINTS_FOR,
            'POINTS_AGST' => $this->POINTS_AGST,
            'REBOUNDS' => $this->REBOUNDS,
            'TURNOVERS' => $this->TURNOVERS,
            'STEALS' => $this->STEALS,
            'ASSISTS' => $this->ASSISTS,
        ]);

        return $dataProvider;
    }
}
