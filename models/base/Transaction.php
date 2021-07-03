<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "transaction".
 *
 * @property integer $id
 * @property string $date_transaction
 * @property string $montant
 * @property integer $decaissement_id
 *
 * @property \app\models\Decaissement $decaissement
 */
class Transaction extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_transaction', 'montant', 'decaissement_id'], 'required'],
            [['date_transaction'], 'safe'],
            [['montant'], 'number'],
            [['decaissement_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_transaction' => 'Date Transaction',
            'montant' => 'Montant',
            'decaissement_id' => 'Decaissement ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecaissement()
    {
        return $this->hasOne(\app\models\Decaissement::className(), ['id' => 'decaissement_id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
           
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\TransactionQuery(get_called_class());
    }
}
