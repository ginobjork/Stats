<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LineupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lineup-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'GAME_ID') ?>

    <?= $form->field($model, 'TEAM_ID') ?>

    <?= $form->field($model, 'PLAYER1') ?>

    <?php // echo $form->field($model, 'PLAYER2') ?>

    <?php // echo $form->field($model, 'PLAYER3') ?>

    <?php // echo $form->field($model, 'PLAYER4') ?>

    <?php // echo $form->field($model, 'PLAYER5') ?>

    <?= echo $form->field($model, 'PERIOD_START') ?>

    <?= echo $form->field($model, 'START_TIME') ?>

    <?= echo $form->field($model, 'PERIOD_END') ?>

    <?= echo $form->field($model, 'END_TIME') ?>

    <?= echo $form->field($model, 'PLAY_TIME') ?>

    <?= echo $form->field($model, 'POINTS_FOR') ?>

    <?= echo $form->field($model, 'POINTS_AGST') ?>

    <?= echo $form->field($model, 'REBOUNDS') ?>

    <?= echo $form->field($model, 'TURNOVERS') ?>

    <?= echo $form->field($model, 'STEALS') ?>

    <?= echo $form->field($model, 'ASSISTS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
