<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace app\models;

use Da\User\Query\UserQuery;
use Da\User\Search\UserSearch as baseModel;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends baseModel
{

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('usuario', 'Nom d\'utilisateur'),
            'email' => \Yii::t('usuario', 'Email'),
            'registration_ip' => \Yii::t('usuario', 'IP d\'enregistrement'),
            'created_at' => \Yii::t('usuario', 'Heure d\'inscription'),
            'last_login_at' => \Yii::t('usuario', 'Dernière connexion'),
        ];
    }

    
}
