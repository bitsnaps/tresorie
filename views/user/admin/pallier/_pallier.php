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

ArrayHelper::map(app\models\User::find()->all(), 'id', 'username'),

['prompt' => 'Sélectionner Utilisateur']);
?>
<?= $form->field($grade, 'role_id')->dropDownList(

ArrayHelper::map(app\models\AuthItem::find(['name'=>'Aprobateur'])->all(), 'id', 'name'),

['prompt' => 'Sélectionner Le Role']);
?>
<?= $form->field($grade, 'niveau')->textInput(['maxlength' => 255]) ?>
<?= $form->field($grade, "montant")->widget(MaskMoney::classname(), [
        'name' => 'price',
        'value' => null,
        'options' => [
            'placeholder' => 'Modifier Montant...',
            'style' => 'width:300 px'
        ],

                                        ]); ?>