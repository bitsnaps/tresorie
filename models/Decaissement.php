<?php

namespace app\models;

use \app\models\base\Decaissement as BaseDecaissement;

/**
 * This is the model class for table "decaissement".
 */
class Decaissement extends BaseDecaissement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [[ 'montant', 'motif', 'piece_jointe',], 'required'],
            [['id','status_user', 'status_admin','date_demande'], 'safe'],
            [['montant'], 'number'],
            [['status_user', 'status_admin', 'user_id'], 'integer'],
            [['motif', 'piece_jointe'], 'string', 'max' => 255],
            [['date_demande'], 'unique'],
           // [['lock'], 'default', 'value' => '0'],
           // [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
