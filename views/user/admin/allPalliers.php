<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tous les palliers');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginContent('@app/views/user/shared/admin_layout_pallier.php') ?>
<div class="grade-index">



    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>'', 
        'columns' => [
            'user_id',
            'role_id',
            'niveau',
            'montant',
          
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<?php $this->endContent() ?>