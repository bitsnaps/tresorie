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
 * @property integer $decaissment_id
 *
 * @property \app\models\Decaissement $decaissment
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
            [['date_transaction', 'montant', 'decaissment_id'], 'required'],
            [['date_transaction'], 'safe'],
            [['montant'], 'number'],
            [['decaissment_id'], 'integer']
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
            'decaissment_id' => 'Decaissment ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecaissment()
    {
        return $this->hasOne(\app\models\Decaissement::className(), ['id' => 'decaissment_id']);
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
