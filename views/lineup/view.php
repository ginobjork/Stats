<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MyLineup */

$this->title = $model->GAME_ID;
$this->params['breadcrumbs'][] = ['label' => 'Lineups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lineup-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'GAME_ID' => $model->GAME_ID, 'TEAM_ID' => $model->TEAM_ID, 'PLAYER1' => $model->PLAYER1, 'PLAYER2' => $model->PLAYER2, 'PLAYER3' => $model->PLAYER3, 'PLAYER4' => $model->PLAYER4, 'PLAYER5' => $model->PLAYER5, 'PERIOD_START' => $model->PERIOD_START, 'START_TIME' => $model->START_TIME], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'GAME_ID' => $model->GAME_ID, 'TEAM_ID' => $model->TEAM_ID, 'PLAYER1' => $model->PLAYER1, 'PLAYER2' => $model->PLAYER2, 'PLAYER3' => $model->PLAYER3, 'PLAYER4' => $model->PLAYER4, 'PLAYER5' => $model->PLAYER5, 'PERIOD_START' => $model->PERIOD_START, 'START_TIME' => $model->START_TIME], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'GAME_ID',
            'TEAM_ID',
            'PLAYER1',
            'PLAYER2',
            'PLAYER3',
            'PLAYER4',
            'PLAYER5',
            'PERIOD_START',
            'START_TIME',
            'PERIOD_END',
            'END_TIME',
            'PLAY_TIME',
            'POINTS_FOR',
            'POINTS_AGST',
            'REBOUNDS',
            'TURNOVERS',
            'STEALS',
            'ASSISTS',
        ],
    ]) ?>

</div>
