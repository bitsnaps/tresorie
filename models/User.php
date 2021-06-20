<?php 
namespace app\models;

use Da\User\Model\User as BaseUser;

class User extends BaseUser
{
    public static function tableName()
    {
        return '{{%user}}';
    }
}