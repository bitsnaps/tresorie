<?php

namespace app\models;

use \app\models\base\Grade as BaseGrade;

/**
 * This is the model class for table "grade".
 */
class Grade extends BaseGrade
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'role_id', 'niveau', 'montant'], 'required'],
            [['user_id', 'role_id'], 'integer'],
            [['montant'], 'number'],
            [['niveau'], 'string', 'max' => 255],
          //  [['lock'], 'default', 'value' => '0'],
           // [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
