<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MyLineup */

$this->title = 'Update Lineup: ' . $model->GAME_ID;
$this->params['breadcrumbs'][] = ['label' => 'Lineups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GAME_ID, 'url' => ['view', 'GAME_ID' => $model->GAME_ID, 'TEAM_ID' => $model->TEAM_ID, 'PLAYER1' => $model->PLAYER1, 'PLAYER2' => $model->PLAYER2, 'PLAYER3' => $model->PLAYER3, 'PLAYER4' => $model->PLAYER4, 'PLAYER5' => $model->PLAYER5, 'PERIOD_START' => $model->PERIOD_START, 'START_TIME' => $model->START_TIME]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lineup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
