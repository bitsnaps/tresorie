<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Decaissement */

$this->title = Yii::t('app', 'Create Decaissement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Decaissements'), 'url' => ['create-demande']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="decaissement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
