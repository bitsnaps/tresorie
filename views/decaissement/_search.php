<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DecaissementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="decaissement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_demande') ?>

    <?= $form->field($model, 'montant') ?>

    <?= $form->field($model, 'motif') ?>

    <?= $form->field($model, 'piece_jointe') ?>

    <?php // echo $form->field($model, 'status_user') ?>

    <?php // echo $form->field($model, 'status_admin') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
