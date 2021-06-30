<?php

use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\Decaissement */
/* @var $form yii\widgets\ActiveForm */
?>


    <?= $form->field($model, 'montant')->textInput(['type' => 'number',   'min'=>0, 'options' => [
        'placeholder' => 'Entrer  Montant...',
        'style' => 'width:300 px',
     
    ]]) ?>
    

    <?= $form->field($model, 'motif')->textArea() ?>

    <?= $form->field($model, 'piece_jointe')->fileInput() ?>

  

    




