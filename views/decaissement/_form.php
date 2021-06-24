<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Decaissement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="decaissement-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_demande')->textInput() ?>

    <?= $form->field($model, 'montant')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'motif')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'piece_jointe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_user')->textInput() ?>

    <?= $form->field($model, 'status_admin')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
