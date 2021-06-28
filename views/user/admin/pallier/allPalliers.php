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
            [
                'attribute' => 'user_id',
                'label' => 'Utilisateur',
                'value' => function ($model) {
                    
                    $user=User::find()->where(['id'=>$model->user_id])->all();
                        return $user[0]->username;
                   
                },
    
            ],
            [
                'attribute' => 'role_id',
                'label' => 'Role',
                'value' => function ($model) {
                    
                    $role=Role::find()->where(['id'=>$model->role_id])->all();
                    if($role)
                        return $role[0]->role_name;
                    else
                        return '';
                },
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