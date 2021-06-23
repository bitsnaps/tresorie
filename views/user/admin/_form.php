<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\Grade */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="grade-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'user_id')->dropDownList(

    ArrayHelper::map(app\models\User::find()->where(['id'=>$model->user_id])->all(), 'id', 'username'),

    ['prompt' => 'Sélectionner Utilisateur']);
    ?>
    <?= $form->field($model, 'role_id')->dropDownList(

    ArrayHelper::map(app\models\Role::find()->where(['id'=>$model->role_id])->all(), 'id', 'role_name'),

    ['prompt' => 'Sélectionner Le Role']);
    ?>
    <?= $form->field($model, 'niveau')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, "montant")->widget(MaskMoney::classname(), [
        'name' => 'price',
        'value' => null,
        'options' => [
            'placeholder' => 'Modifier Montant...',
            'style' => 'width:300 px'
        ],

                                        ]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
