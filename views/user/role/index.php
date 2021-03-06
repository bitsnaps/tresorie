<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var $dataProvider array
 * @var $searchModel  \Da\User\Search\RoleSearch
 * @var $this         yii\web\View
 */

$this->title = Yii::t('usuario', 'Roles');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginContent('@app/views/user/shared/admin_layout_role.php') ?>

<?= GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'attribute' => 'name',
                'header' => Yii::t('usuario', 'Name'),
                'options' => [
                    'style' => 'width: 20%',
                ],
            ],
            [
                'attribute' => 'description',
                'header' => Yii::t('usuario', 'Description'),
                'options' => [
                    'style' => 'width: 55%',
                ],
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, $model) {
                    return Url::to(['/user/role/' . $action, 'name' => $model['name']]);
                },
                'options' => [
                    'style' => 'width: 5%',
                ],
            ],
        ],
    ]
) ?>

<?php $this->endContent() ?>
