<?php

namespace app\models;

use \app\models\base\Decaissementhistorique as BaseDecaissementhistorique;

/**
 * This is the model class for table "decaissementhistorique".
 */
class Decaissementhistorique extends BaseDecaissementhistorique
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
           // [['motif', 'piece_jointe'], 'string', 'max' => 255],
            [['date_demande'], 'unique']
        ]);
    }
	
}
