<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lineup */

$this->title = 'Create Lineup';
$this->params['breadcrumbs'][] = ['label' => 'Lineups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-lineup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
