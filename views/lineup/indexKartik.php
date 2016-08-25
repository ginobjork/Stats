<?php

use app\models\Lineup;
use app\models\LineupSummary;

use Yii;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LineupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lineup Analisys';
$this->params['breadcrumbs'][] = $this->title;

Yii::trace(print_r($dataProvider, TRUE));
$r = new ReflectionClass($dataProvider->modelClass);
$model = $r->newInstanceArgs();
Yii::trace(print_r($model, TRUE));

$labels = $model->attributeLabels();
$tooltips = $model->tooltips();
?>
<div class="lineup-index">

    <!--<h1><?= Html::encode($this->title) ?></h1> -->
<!--<div id="tableContainer" class="tableContainer"> -->
<?php 
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
SCRIPT;
	// Register tooltip/popover initialization javascript
	$this->registerJs($js);

?>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        /*
        'headerRowOptions' => [
			'class' => "fixedHeader",
			'id' => "fixedHeader",
		],
		*/
        'summary' => "",
        //'floatHeader' => true,
        //'floatOverflowContainer' => true,
        //'floatHeaderOptions' => [
		//	'scrollContainer' => "function(\$table){return document.getElementById('w0-container');}",
        //],
        'containerOptions'=>['class'=>'tableContainer'],
        //'panel' => false,
        
		'panel'=>[
			'type'=>GridView::TYPE_PRIMARY,
			'heading'=>'<i class="glyphicon glyphicon-book"></i> Library',
		],
        /*
        'perfectScrollbar' => true,
        'perfectScrollbarOptions' => [
			'suppressScrollX' => true,
		],*/
		'pjax'=>true,
		'pjaxSettings'=>[
			'neverTimeout'=>true,
			'options' => [
				'id' => 'layup-pjax-id',
				'enablePushState' => false,
			],
		],
		'export' => false,
		/*[
			'exportConfig' => [
				GridView::CSV => [
					'label' => 'CSV',
				],
				GridView::EXCEL => [
					'label' => 'Excel',
				],
			],
		],*/	
       'columns' => [
            [
				'class' => 'yii\grid\SerialColumn',
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:25px;", 
				],
				'headerOptions' => 
					[
						'style' => "width:25px;", 
						'class' => "titleHeaderCenter",
					]
			],
			[
				'attribute' => 'PLAYERS',
				'value' => 'PLAYERS',
				'header' => ($labels['PLAYERS'] . " " . $model->getFunctionLabel() . "<i class=\"lineup glyphicon glyphicon-transfer\" aria-hidden=\"true\"></i><a class=\"lineup\" href=\"/index.php?r=lineup%2F" . strtolower($model->getAltFunctionLabel()) . "\">" . $model->getAltFunctionLabel() . "</a>"),
				'headerOptions' => 
					[
						'title' => $tooltips['PLAYERS'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip",
						'data-trigger'=>"hover", 
						'style' => "width:580px;", 
					],
				'contentOptions' => [
					'class' => "descColumn",
					'style' => "width:580px;", 
				],
			],
			[
				'attribute' => 'PERIOD_START',
				'value' => 'PERIOD_START',
				'label' => $labels['PERIOD_START'],
				'headerOptions' => 
					[
						'title' => $tooltips['PERIOD_START'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:35px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:35px;", 
				],
			],
			[
				'attribute' => 'START_TIME',
				'value' => 'START_TIME',
				'label' => $labels['START_TIME'],
				'headerOptions' => 
					[
						'title' => $tooltips['START_TIME'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:50px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "timeColumn",
					'style' => "width:50px;", 
				],
			],
			/*
			[
				'attribute' => 'PERIOD_END',
				'value' => 'PERIOD_END',
				'label' => $labels['PERIOD_END'],
				'headerOptions' => 
					[
						'title' => $tooltips['PERIOD_END'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:45px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:45px;", 
				],
			],
			[
				'attribute' => 'END_TIME',
				'value' => 'END_TIME',
				'label' => $labels['END_TIME'],
				'headerOptions' => 
					[
						'title' => $tooltips['END_TIME'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip",
						'data-trigger'=>"hover", 
						'style' => "width:50px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "timeColumn",
					'style' => "width:50px;", 
				],
			],
			*/
			[
				'attribute' => 'PLAY_TIME',
				'value' => 'PLAY_TIME_STR',
				'label' => $labels['PLAY_TIME'],
				'headerOptions' => 
					[
						'title' => $tooltips['PLAY_TIME'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:50px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "timeColumn",
					'style' => "width:50px;", 
				],
			],
			[
				'attribute' => 'POINTS',
				'value' => 'POINTS',
				'label' => $labels['POINTS'],
				'headerOptions' => 
					[
						'title' => $tooltips['POINTS'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:35px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:35px;", 
				],
			],
			[
				'attribute' => 'POINTS_FOR',
				'value' => 'POINTS_FOR',
				'label' => $labels['POINTS_FOR'],
				'headerOptions' => 
					[
						'title' => $tooltips['POINTS_FOR'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:35px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:35px;", 
				],
			],
			[
				'attribute' => 'POINTS_AGST',
				'value' => 'POINTS_AGST',
				'label' => $labels['POINTS_AGST'],
				'headerOptions' => 
					[
						'title' => $tooltips['POINTS_AGST'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:35px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:35px;", 
				],
			],
			[
				'attribute' => 'REBOUNDS',
				'value' => 'REBOUNDS',
				'label' => $labels['REBOUNDS'],
				'headerOptions' => 
					[
						'title' => $tooltips['REBOUNDS'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:35px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:35px;", 
				],
			],
			[
				'attribute' => 'TURNOVERS',
				'value' => 'TURNOVERS',
				'label' => $labels['TURNOVERS'],
				'headerOptions' => 
					[
						'title' => $tooltips['TURNOVERS'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:35px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:35px;", 
				],
			],
			[
				'attribute' => 'STEALS',
				'value' => 'STEALS',
				'label' => $labels['STEALS'],
				'headerOptions' => 
					[
						'title' => $tooltips['STEALS'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:35px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:35px;", 
				],
			],
			[
				'attribute' => 'ASSISTS',
				'value' => 'ASSISTS',
				'label' => $labels['ASSISTS'],
				'headerOptions' => 
					[
						'title' => $tooltips['ASSISTS'],
						'data-placement'=>"top",
						'data-container'=>"body",
						'data-toggle'=>"tooltip", 
						'data-trigger'=>"hover", 
						'style' => "width:35px;", 
						'class' => "titleHeaderCenter",
					],
				'contentOptions' => [
					'class' => "statColumn",
					'style' => "width:35px;", 
				],
			],
        ],
    ]); ?>
</div>
</div>
