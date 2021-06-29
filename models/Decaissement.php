<?php

namespace app\models;

use \app\models\base\Decaissement as BaseDecaissement;

/**
 * This is the model class for table "decaissementhistorique".
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
            [['montant', 'motif', 'piece_jointe'], 'required'],
            [['date_demande'], 'safe'],
            [['montant'], 'number'],
            [['status_user', 'status_admin', 'sender_user_id', 'reciever_user_id'], 'integer'],
            [['date_demande'], 'unique']
        ]);
    }
	
}
