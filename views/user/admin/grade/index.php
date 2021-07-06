<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use app\models\Role;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tous les Paliers');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginContent('@app/views/user/shared/admin_layout_palier.php') ?>
<div class="grade-index">



    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>'', 
        'columns' => [
            [
                'attribute' => 'userID',
                'label' => 'Utilisateur',
                'value' => 'user.username'
                
            ],
            [
                'attribute' => 'roleID',
                'label' => 'Role',
                'value' => 'role.role_name'
            ],
          //  'niveau',
            [
                'attribute' => 'montant',
                'format' => 'raw',
                'label' => 'Montant',
               
                'value' => function ($model) {
                    
                    return $model->montant.' DA';
                },
            ],
          
          
            ['class' => 'yii\grid\ActionColumn'],
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