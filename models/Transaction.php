<?php

namespace app\models;

use \app\models\base\Transaction as BaseTransaction;

/**
 * This is the model class for table "transaction".
 */
class Transaction extends BaseTransaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['date_transaction', 'montant', 'decaissment_id'], 'required'],
            [['date_transaction'], 'safe'],
            [['montant'], 'number'],
            [['decaissment_id'], 'integer']
        ]);
    }
	
}
