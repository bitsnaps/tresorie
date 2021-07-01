<?php

namespace app\Query;

use app\models\User;
use app\models\AuthAssignment;
use app\models\Decaissement;



/**
 * This is the model class for table "grade".
 */
class kpiQuery
{
    public static function countUserByRole($role_name){
        return AuthAssignment::find()->where(['item_name'=>$role_name])->count();

    }
    
    public static  function countDecaissement(){
       return  Decaissement::find()->count();
    }

	
}
