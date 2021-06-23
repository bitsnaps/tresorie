<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use app\models\Role;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\Grade */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Grades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="grade-view">

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
                        return $role[0]->role_name;
                },
            ],
            'niveau',
            [
                'attribute' => 'montant',
         
                'label' => 'Montant',
               
                'value' => function ($model) {
                    
                    return   $model->montant.' DA';
                },
            ],
        ],
    ]) ?>

</div>
