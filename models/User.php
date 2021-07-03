<?php

namespace app\models;

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
        /**
     * {@inheritdoc}
     */
    public $role;

    public function rules()
    {
        return array_merge(parent::rules(), [ 
            [['role'],'safe']
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
        
        //$User = new self();  
        if (User::userHasRole('Administrateur', User::getCurrentUser()->id)){
            return  true;
        }
          
        return  false;
    }
    public static  function isAdminBehavior()
    {
        //$User = new self();  
        die();
        if (User::userHasRole('Administrateur', User::getCurrentUser()->id))
            return  ['Administrateur'];
    }
    public static  function isAprobateur()
    {
        //$User = new self();  
        if (User::userHasRole('Approbateur', User::getCurrentUser()->id))
            return  true;
        return  false;
    }
    public static  function isResponsableDeStation()
    {
        //$User = new self();  
        if (User::userHasRole('Utilisateur', User::getCurrentUser()->id))
            return  true;
        return  false;
    }

    public static function decaissementAuthorirty($status_user)
    {
        if ($status_user != 1)
            return  true;
        else
            return false;
    }
    public static function authAssignementResponsableDeStationToConfirmedUser($user_id,$roleName)
    {
        $model = new \app\models\AuthAssignment();
        $model->item_name = $roleName;
        $model->user_id = $user_id;

        if ($model->save()) {
        } else {
            print_r($model);
            die();
        }
        $model = new \app\models\Role();
        $model->role_name = $roleName;
        $model->user_id = $user_id;

        if ($model->save()) {
        } else {
            print_r($model);
            die();
        }
    }
    public static function assignRoleToConfirmedUser($user_id,$roleName)
    {
        $model1 = \app\models\AuthItem::find()->where(['name' =>$roleName ])->one();
        if ($model1) {
            self::authAssignementResponsableDeStationToConfirmedUser($user_id,$roleName);
            //je cree l'utilisateur 
        } else {
            $model1 = new \app\models\AuthItem;
            $model1->name = $roleName;
            $model1->type = 1;

            if ($model1->save()) {
                self::authAssignementResponsableDeStationToConfirmedUser($user_id,$roleName);
            } else {
                print_r($model1);
                die();
            }
            //Saving role for new confirmed user 

        }
    }
}
