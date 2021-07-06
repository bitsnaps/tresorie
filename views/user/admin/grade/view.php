<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Grade */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Grade', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Grade'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'user_id',
            'label' => 'Utilisateur',
            'value' => function ($model) {
                
                $user=app\models\User::find()->where(['id'=>$model->user_id])->all();
                    return $user[0]->username;
               
            },

        ],
        [
            'attribute' => 'role_id',
            'label' => 'Role',
            'value' => function ($model) {
                
                $role=app\models\Role::find()->where(['id'=>$model->role_id])->all();
                if($role)
                    return $role[0]->role_name;
                else 
                return "";
            },
        ],
        'niveau',
        'montant',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>