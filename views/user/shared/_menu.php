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
                'label' => Yii::t('usuario', 'rôles'),
                'url' => ['/user/role/index'],
                'visible' => User::isAdmin()
            ],
            [
                'label' => Yii::t('usuario', 'Grade'),
                'url' => ['/admin/palliers'],
                'visible' => User::isAdmin()
            ],
            [
                'label' => Yii::t('usuario', 'Tous les Décaissements'),
                'url' => ['/admin/decaissement'],
                'visible' => User::isAdmin()
            ],
            [
                'label' => Yii::t('usuario', 'Créer une demande'),
                'url' => ['/responsable-de-station/create-demande'],
                'visible' => User::isResponsableDeStation()
            ],
            [
                'label' => Yii::t('usuario', 'Mes Décaissements'),
                'url' => ['/responsable-de-station/decaissement'],
                'visible' => User::isResponsableDeStation()
            ],

          /*  [
                'label' => Yii::t('usuario', 'Permissions'),
                'url' => ['/user/permission/index'],
            ],
            [
                'label' => Yii::t('usuario', 'Règles'),
                'url' => ['/user/rule/index'],
            ],*/
            [
                'label' => Yii::t('usuario', 'Créer'),
                'items' => [
                    [
                        'label' => Yii::t('usuario', 'Nouvelle utilisateur'),
                        'url' => ['/user/admin/create'],
                    ],
                   /* [
                        'label' => Yii::t('usuario', 'Nouveau role'),
                        'url' => ['/user/role/create'],
                    ],*/
                    [
                        'label' => Yii::t('usuario', 'Nouveau Grade'),
                        'url' => ['/admin/create-pallier'],
                    ],
                   /* [
                        'label' => Yii::t('usuario', 'Nouvelle permission'),
                        'url' => ['/user/permission/create'],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Nouvelle regle'),
                        'url' => ['/user/rule/create'],
                    ],*/
                ]
                , 'visible' => User::isAdmin()
            ],
        ],
    ]
) ?>
