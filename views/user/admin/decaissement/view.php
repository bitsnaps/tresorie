<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Decaissement */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Decaissements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="decaissement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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

                    return $model->montant . ' DA';
                },
            ],
            'motif',
           // 'piece_jointe',
           [
            'label' => Yii::t('usuario', 'état demande'),
            'value' => function ($model) {
                if ($model->status_user == '1') {
                    return Html::a(
                        Yii::t('usuario', 'Confirm'),
                        ['confirm', 'id' => $model->id],
                        [
                            'class' => 'btn btn-xs btn-success btn-block disabled',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('usuario', 'Are you sure you want to confirm this user?'),
                        ]
                    );
                } else
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
            'format' => 'html',
            'visible' => true,
        ],
        [
            'label' => Yii::t('usuario', 'Suivi admin'),
            'value' => function ($model) {
                if ($model->status_admin == '2') {
                    return Html::a(
                        Yii::t('usuario', 'Confirm'),
                        ['confirm', 'id' => $model->id],
                        [
                            'class' => 'btn btn-xs btn-success btn-block disabled',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('usuario', 'Are you sure you want to confirm this user?'),
                        ]
                    );
                } else
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
            'format' => 'html',
            'visible' => User::isResponsableDeStation(),
        ],
            
        ],
    ]) ?>

</div>
