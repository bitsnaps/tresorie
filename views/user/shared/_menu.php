<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\bootstrap\Nav;
use app\models\User;

?>

<?= Nav::widget(
    [
        'options' => [
            'class' => 'nav-tabs',
            'style' => 'margin-bottom: 15px',
        ],
        'items' => [
            [
                'label' => Yii::t('usuario', 'Utilisateur'),
                'url' => ['/user/admin/index'],
                'visible' => User::isAdmin()
            ],
            [
                'label' => Yii::t('usuario', 'Rôles'),
                'url' => ['/user/role/index'],
                'visible' => User::isAdmin()
            ],
            [
                'label' => Yii::t('usuario', 'Grade'),
                'url' => ['/grade/index'],

                'visible' => User::isAdmin()
            ],
            [
                'label' => Yii::t('usuario', 'Décaissement'),
                'url' => ['/decaissement/index'],
                'visible' => User::isAdmin()
            ],
            [
                'label' => Yii::t('usuario', 'Transactions'),
                'url' => ['/transaction/index'],
                'visible' => User::isAdmin()
            ],
            [
                'label' => Yii::t('usuario', 'Créer une demande'),
                'url' => ['/decaissement/create'],
                'visible' => User::isResponsableDeStation()
            ],
            [
                'label' => Yii::t('usuario', 'Mes Décaissement'),
                'url' => ['/decaissement/index'],
                'visible' => User::isResponsableDeStation()
            ],
            [
                'label' => Yii::t('usuario', 'Créer'),
                'items' => [
                    [
                        'label' => Yii::t('usuario', 'Nouvelle utilisateur'),
                        'url' => ['/user/admin/create'],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Nouveau Grade'),
                        
                        'url' => ['/grade/create'],

                    ],
                ]
                , 'visible' => User::isAdmin()
            ],
        ],
    ]
) ?>
