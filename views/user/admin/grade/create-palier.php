<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var yii\web\View        $this
 * @var \Da\User\Model\User $user
 */

$this->title = Yii::t('usuario', 'Cree un palier');
$this->params['breadcrumbs'][] = ['label' => Yii::t('usuario', 'Grade'), 'url' => ['create-Palier']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="clearfix"></div>
<?= $this->render(
        '/user/shared/_alert',
        [
            'module' => Yii::$app->getModule('user'),
        ]
    ) ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?= $this->render('/user/shared/_menu') ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?= Nav::widget(
                                    [
                                        'options' => [
                                            'class' => 'nav-pills nav-stacked',
                                        ],
                                        'items' => [
                                            [
                                                'label' => Yii::t('usuario', 'Lister tous les Paliers'),
                                                'url' => ['/admin/Paliers'],
                                               /* 'options' => [
                                                    'class' => 'disabled',
                                                    'onclick' => 'return false;',
                                                ],*/
                                            ],
                                            [
                                                'label' => Yii::t('usuario', 'Création Palier'),
                                                'url' => ['admin/create-Palier'],
                                                  'options' => [
                                                  
                                                   
                                                ],
                                            ],

                                        ],
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="alert alert-info">
                                    <?= Yii::t('usuario', "Palier sera affecté par suite à l'approbateur sélectionné") ?>.
                                   
                                </div>
                                <?php $form = ActiveForm::begin(
                               
                                    [
                                      //  'action' => ['admin/save-Palier'],
                                        'method' => 'post',
                                        'layout' => 'horizontal',
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => true,
                                        'options'=>[
                                            'enctype' => 'multipart/form-data'
                                        ],
                                        'fieldConfig' => [
                                            'horizontalCssClasses' => [
                                                'wrapper' => 'col-sm-9',
                                            ],
                                        ],
                                    ]
                                ); ?>

                                <?= $this->render('_form_create', ['form' => $form, 'grade' => $grade]) ?>


                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-9">
                                        <?= Html::submitButton(
                                            Yii::t('usuario', 'Save'),
                                            ['class' => 'btn btn-block btn-success']
                                        ) ?>
                                    </div>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
