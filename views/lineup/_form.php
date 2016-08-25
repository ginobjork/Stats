<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MyLineup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lineup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'GAME_ID')->textInput() ?>

    <?= $form->field($model, 'TEAM_ID')->textInput() ?>

    <?= $form->field($model, 'PLAYER1')->textInput() ?>

    <?= $form->field($model, 'PLAYER2')->textInput() ?>

    <?= $form->field($model, 'PLAYER3')->textInput() ?>

    <?= $form->field($model, 'PLAYER4')->textInput() ?>

    <?= $form->field($model, 'PLAYER5')->textInput() ?>

    <?= $form->field($model, 'PERIOD_START')->textInput() ?>

    <?= $form->field($model, 'START_TIME')->textInput() ?>

    <?= $form->field($model, 'PERIOD_END')->textInput() ?>

    <?= $form->field($model, 'END_TIME')->textInput() ?>

    <?= $form->field($model, 'PLAY_TIME')->textInput() ?>

    <?= $form->field($model, 'POINTS_FOR')->textInput() ?>

    <?= $form->field($model, 'POINTS_AGST')->textInput() ?>

    <?= $form->field($model, 'REBOUNDS')->textInput() ?>

    <?= $form->field($model, 'TURNOVERS')->textInput() ?>

    <?= $form->field($model, 'STEALS')->textInput() ?>

    <?= $form->field($model, 'ASSISTS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
