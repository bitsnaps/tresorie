<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
use yii\helpers\ArrayHelper;

?>


<?= $form->field($user, 'email')->textInput(['placeholder' => 'Entrer l\'email...','maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['placeholder' => 'Entrer le nom d\'utilisateur...','maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput(['placeholder' => 'Entrer un mot de passe...']) ?>
<?= $form->field($user, 'role')->dropDownList(

ArrayHelper::map(app\models\AuthItem::find()->where([])->all(), 'name', 'name'),

    ['prompt' => 'Sélectionner un Role']);
    ?>
