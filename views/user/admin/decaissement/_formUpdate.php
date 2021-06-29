<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\Decaissement */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'montant')->textInput(['type' => 'number','min'=>0, 'options' => [
    'placeholder' => 'Modifier Montant.',
    'style' => 'width:300 px',
    'min'=>0,
]]) ?>

<?= $form->field($model, 'motif')->textArea() ?>

<?= $form->field($model, 'piece_jointe')->fileInput() ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>