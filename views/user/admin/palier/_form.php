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

        ArrayHelper::map(

            app\models\AuthAssignment::find()->joinWith('user')->where(['item_name' => "Approbateur"])->all(),
            'user.id',
            function ($model) {
                //   return ArrayHelper::toArray($model->user->username);
                return $model->user->username;
            }
        ),

        ['prompt' => 'Sélectionner Utilisateur']
    );
    ?>
    <?= $form->field($model, 'role_id')->dropDownList(

        ArrayHelper::map(app\models\AuthItem::find()->where(['name' => 'Approbateur'])->all(), 'name', 'name'),

        ['prompt' => 'Sélectionner Le Role']
    );
    ?>
    <?= $form->field($model, 'niveau')->textInput(['placeholder' => 'Entrer  un niveau...','maxlength' => 255]) ?>
    <?= $form->field($model, 'montant')->textInput(['type' => 'number','placeholder' => 'Entrer  un Montant...', 'min' => 0, 'options' => [
        
        'min' => 0,
        'style' => 'width:300 px'
    ]]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>