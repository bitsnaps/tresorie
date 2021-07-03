<?php

use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\Decaissement */
/* @var $form yii\widgets\ActiveForm */
?>


    <?= $form->field($model, 'montant')->textInput(['type' => 'number',   'min'=>0,'placeholder' => 'Entrer le  Montant...', 'options' => [
        
        'style' => 'width:300 px',
     
    ]]) ?>
    

    <?= $form->field($model, 'motif')->textArea(['placeholder' => 'Entrer  un Motif...',]) ?>

    <?= $form->field($model, 'piece_jointe')->fileInput() ?>

  

    




