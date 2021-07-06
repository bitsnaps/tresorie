<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Decaissement */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Décaissements'), 'url' => ['']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="decaissement-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'label' => 'Utilisateur',

                'value' => function ($model) {

                    return $model->senderUser->username;
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
            'header' => Yii::t('usuario', 'Etat demande'),
            'label' => 'Etat demande',
            'value' => function ($model) {
                if ($model->status_admin == '2') {
                    return Html::a(
                        Yii::t('usuario', 'Validé'),
                        ['confirm', 'id' => $model->id],
                        [
                            'class' => 'btn btn-xs btn-success btn-block disabled',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('usuario', 'Are you sure you want to confirm this user?'),
                        ]
                    );
                } else
                    return Html::a(
                        Yii::t('usuario', 'En cours de validation'),
                        ['confirm', 'id' => $model->id],
                        [
                            'class' => 'btn btn-xs btn-warning btn-block disabled',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('usuario', 'Are you sure you want to confirm this user?'),
                        ]
                    );
            },
            'format' => 'raw',
            'visible' => true,
        ]


        ],
    ]) ?>

</div>
