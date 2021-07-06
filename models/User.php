<?php

namespace app\models;
use Yii;

use Da\User\Model\User as BaseUser;

/**
 * User ActiveRecord model.
 *
 * @property string $role
 * 
 * 
 */

class User extends BaseUser
{
    public $password_changed_at;
    /**
     * {@inheritdoc}
     */
    public $role;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['role'], 'safe']
        ]);
    }
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('usuario', 'Nom d\'utilisateur'),
            'email' => \Yii::t('usuario', 'Email'),
            'registration_ip' => \Yii::t('usuario', 'IP d\'enregistrement'),
            'unconfirmed_email' => \Yii::t('usuario', 'Nouveau courriel'),
            'password' => \Yii::t('usuario', 'Mot de passe'),
            'created_at' => \Yii::t('usuario', 'Heure d\'inscription'),
            'confirmed_at' => \Yii::t('usuario', 'Heure de confirmation'),
            'last_login_at' => \Yii::t('usuario', 'Dernière connexion'),
        ];
    }

    public static function tableName()
    {
        return '{{%user}}';
    }
    public static function getCurrentUser()
    {
        return \Yii::$app->user;
    }
    public static function userHasRole($role, $id)
    {
        $User = new self();
        return $User->getAuth()->hasRole($id, $role);
    }
    public static  function isAdmin()
    {
       // print_r(Yii::$app->params);
        //die();
        if (User::userHasRole(Yii::$app->params['roles'][0], User::getCurrentUser()->id)) {
            return  true;
        }

        return  false;
    }

    public static  function isAprobateur()
    {

        if (User::userHasRole(Yii::$app->params['roles'][1], User::getCurrentUser()->id)) {
            return  true;
        }

        return  false;
    }
    public static  function isResponsableDeStation()
    {

        if (User::userHasRole(Yii::$app->params['roles'][2], User::getCurrentUser()->id)) {
            return  true;
        }

        return  false;
    }

    public static function decaissementAuthorirty($status_user)
    {
        if ($status_user != 1) {
            return  true;
        } else {
            return false;
        }
    }
    public static function authAssignementResponsableDeStationToConfirmedUser($user_id, $roleName)
    {
        $model = new \app\models\AuthAssignment();
        $model->item_name = $roleName;
        $model->user_id = $user_id;

        if ($model->save()) {
        } else {
            throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas confirmer cette utilisateur'));
        }
        $model = new \app\models\Role();
        $model->role_name = $roleName;
        $model->user_id = $user_id;
        if ($model->save()) {
        } else {
            throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas confirmer cette utilisateur'));
        }
    }
    public static function assignRoleToConfirmedUser($user_id, $roleName)
    {

        self::authAssignementResponsableDeStationToConfirmedUser($user_id, $roleName);
    }
}
