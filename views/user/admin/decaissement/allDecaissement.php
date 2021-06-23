<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DecaissementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Decaissements');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginContent('@app/views/user/shared/admin_layout_decaissement.php') ?>
<div class="decaissement-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>'', 
        'columns' => [
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'label' => 'Utilisateur',
               
                'value' => function ($model) {
                    
                    return $model->user->username;
                },
            ],
            'date_demande',
            [
                'attribute' => 'montant',
                'format' => 'raw',
                'label' => 'Montant',
               
                'value' => function ($model) {
                    
                    return $model->montant.' DA';
                },
            ],
            
           // 'piece_jointe',
            //'status',

            'motif',


            [
                'header' => Yii::t('usuario', 'état demande'),
                'value' => function ($model) {
                    if($model->status_user=='1'){
                        return Html::a(
                            Yii::t('usuario', 'Confirm'),
                            ['confirm', 'id' => $model->id],
                            [
                                'class' => 'btn btn-xs btn-success btn-block disabled',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('usuario', 'Are you sure you want to confirm this user?'),
                            ]
                        );
                    }
                    else
                        return Html::a(
                            Yii::t('usuario', 'Pending'),
                            ['confirm', 'id' => $model->id],
                            [
                                'class' => 'btn btn-xs btn-warning btn-block disabled',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('usuario', 'Are you sure you want to confirm this user?'),
                            ]
                        );
                    
                },
                'format' => 'raw',
                'visible' =>true,
            ],
            [
                'header' => Yii::t('usuario', 'Confirmer la demande '),
                'value' => function ($model) {
                    if ($model->status_admin==2) {
                        return '<div class="text-center">
                                <span class="text-success">' . Yii::t('usuario', 'Confirmed') . '</span>
                            </div>';
                    }
                    if ($model->status_admin==0)
                    return Html::a(
                        Yii::t('usuario', 'Confirmer'),
                        ['confirm-decaissement', 'id' => $model->id],
                        [
                            'class' => 'btn btn-xs btn-success btn-block',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('usuario', 'Are you sure you want to confirm this user?'),
                        ]
                    );
                },
                'format' => 'raw',
                'visible' => Yii::$app->getModule('user')->enableEmailConfirmation,
            ],
            [
                'header' => Yii::t('usuario', 'Blocker la demande'),
                'value' => function ($model) {
                    if ($model->status_admin==1) {
                        return Html::a(
                            Yii::t('usuario', 'Unblock'),
                            ['block-decaissement', 'id' => $model->id],
                            [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('usuario', 'Are you sure you want to unblock this user?'),
                            ]
                        );
                    }
                    if ($model->status_admin==0 or $model->status_admin==2  )
                    return Html::a(
                        Yii::t('usuario', 'Blocker'),
                        ['block-decaissement', 'id' => $model->id],
                        [
                            'class' => 'btn btn-xs btn-danger btn-block',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('usuario', 'Are you sure you want to block this user?'),
                        ]
                    );
                },
                'format' => 'raw',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<?php $this->endContent() ?>