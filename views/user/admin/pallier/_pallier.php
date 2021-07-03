<?php
use yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;
/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm
 * @var \Da\User\Model\User    $user
 */
?>
<?= $form->field($grade, 'user_id')->dropDownList(

ArrayHelper::map(

app\models\AuthAssignment::find()->joinWith('user')->where(['item_name'=>"Aprobateur"])->all(), 'user.id', function ($model) {
 //   return ArrayHelper::toArray($model->user->username);
    return $model->user->username;
}
),

['prompt' => 'Sélectionner Utilisateur']);
?>
<?= $form->field($grade, 'role_id')->dropDownList(

ArrayHelper::map(app\models\AuthItem::find()->where(['name'=>'Aprobateur'])->all(), 'name', 'name'),

['prompt' => 'Sélectionner Le Role']);
?>
<?= $form->field($grade, 'niveau')->textInput([  'placeholder' => 'Entrer  un niveau...','maxlength' => 255]) ?>
<?= $form->field($grade, 'montant')->textInput([  'placeholder' => 'Entrer  un Montant...','type' => 'number','min'=>0, 'options' => [
      
        'min'=>0,
        'style' => 'width:300 px'
    ]]) ?>
