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

$this->title = Yii::t('usuario', 'Crée une demande de décaissement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('usuario', 'décaissement'), 'url' => ['create']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="clearfix"></div>


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
                                                'label' => Yii::t('usuario', 'Lister tous les decassement'),
                                                'url' => ['/responsable-de-station/decaissement'],
                                               /* 'options' => [
                                                    'class' => 'disabled',
                                                    'onclick' => 'return false;',
                                                ],*/
                                            ],
                                            [
                                                'label' => Yii::t('usuario', "Création d'une demande"),
                                                'url' => ['/responsable-de-station/create-demande'],
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
                          <!--// yii\widgets\Pjax::begin(['id' => 'new_country']) -->
                                <?php $form = ActiveForm::begin(
                               
                                    [
                                        'action' => ['create'],
                                        'id' => 'formDecaissement',
                                        'method' => 'post',
                                        'layout' => 'horizontal',
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => true,
                                        'fieldConfig' => [
                                            'horizontalCssClasses' => [
                                                'wrapper' => 'col-sm-9',
                                            ],
                                        ],
                                       // 'options' => ['data-pjax' => true ]
                                    ]
                                ); ?>

                                <?= $this->render('_form', ['form' => $form, 'model' => $decaissement]) ?>

                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-9">
                                        <?= Html::submitButton(
                                            Yii::t('usuario', 'Save'),
                                           
                                            [
                                            'id'=>'SaveDecaissement',
                                            'class' => 'btn btn-block btn-success',
                                            'data-method' => 'post',
                                            //'data-confirm' => Yii::t('usuario', 'etes vous sure de confirmer cette demande?'),
                                        ],
                                        ['create-demande', 'id' => $decaissement->id],
                                      
                                        ) ?>
                                    </div>
                                </div>

                                <?php ActiveForm::end(); ?>
                                <!--// yii\widgets\Pjax::end() -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

