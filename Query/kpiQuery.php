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
    /**
     * function to count user by role
     *
     * @param [type] $role_name
     * @return int
     */
    public static function countUserByRole($role_name){
        return AuthAssignment::find()->where(['item_name'=>$role_name])->count();

    }
    
    /**
     * function count number of decaisement
     *
     * @return int
     */
    public static  function countDecaissement(){
       return  Decaissement::find()->count();
    }

	
}
