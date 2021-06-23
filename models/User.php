<?php 
namespace app\models;

use Da\User\Model\User as BaseUser;

class User extends BaseUser
{
    public static function tableName()
    {
        return '{{%user}}';
    }
    public static function getCurrentUser() {
        return \Yii::$app->user;
    }
    public static function userHasRole($role,$id)
    {
        $User = new self();  
        return $User->getAuth()->hasRole($id, $role);
    }
    public static  function isAdmin()
    {
        //$User = new self();  
        if(User:: userHasRole('admin',User::getCurrentUser()->id))
            return  'admin';
      
    }


}