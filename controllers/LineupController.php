<?php

namespace app\controllers;

use Yii;
use app\models\Lineup;
use app\models\LineupSummary;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;

/**
 * LineupController implements actions for Lineup model.
 */
class LineupController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Lineup models.
     * @return mixed
     */
    public function actionRotation()
    {
 		$lineup = new Lineup();
		$data = $lineup->getData();
        $dataProvider = new ArrayDataProvider([
			'allModels' => $data,
			'pagination' => false,
			'sort' => [
				'attributes' => [
						'PERIOD_START',
						'START_TIME', 
						'PLAY_TIME',
						'POINTS',
						'POINTS_FOR',
						'POINTS_AGST',
						'REBOUNDS',
						'ASSISTS',
						'STEALS', 
						'TURNOVERS', 
				],
				'defaultOrder' => [
					'PERIOD_START' => SORT_ASC,
					'START_TIME' => SORT_DESC, 
				]
			],
			'modelClass' => 'app\models\Lineup',
		]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists summary of al Lineup models.
     * @return mixed
     */
    public function actionSummary()
    {
		$lineup = new LineupSummary();
		$data = $lineup->getData();
        $dataProvider = new ArrayDataProvider([
			'allModels' => $data,
			'pagination' => false,
			'sort' => [
				'attributes' => [
						'PLAY_TIME',
						'POINTS',
						'POINTS_FOR',
						'POINTS_AGST',
						'REBOUNDS',
						'ASSISTS',
						'STEALS', 
						'TURNOVERS', 
				],
				'defaultOrder' => [
					'PLAY_TIME' => SORT_DESC, 
				]
			],
			'modelClass' => 'app\models\LineupSummary',
		]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
   }

}
