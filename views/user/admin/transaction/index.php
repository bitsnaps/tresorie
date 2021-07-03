<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DecaissementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Decaissements');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginContent('@app/views/user/shared/admin_layout_decaissement.php') ?>
<div class="decaissement-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
            [
                'attribute' => 'decaissement_id',
                'format' => 'raw',
                'label' => 'Utilisateur',

                'value' => function ($model) {

                    return $model->decaissment->senderUser->username ;
                },
            ],
            'date_transaction',
            [
                'attribute' => 'montant',
                'format' => 'raw',
                'label' => 'Montant',

                'value' => function ($model) {

                    return $model->montant . ' DA';
                },
            ],
            [
                'attribute' => 'decaissement_id',
                'format' => 'raw',
                'label' => 'Motif',

                'value' => function ($model) {

                    return $model->decaissment->motif ;
                },
            ],

         
        


        ],

    ]); ?>

    <?php Pjax::end(); ?>

</div>
<?php $this->endContent() ?>
<?php
$this->registerJs('
$("body").on("keyup.yiiGridView", ".grid-view .filters input", function(){
    $(".grid-view").yiiGridView("applyFilter");
})', \yii\web\View::POS_READY);
?>