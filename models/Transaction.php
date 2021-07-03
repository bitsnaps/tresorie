<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $date_transaction
 * @property float $montant
 * @property int $decaissment_id
 *
 * @property Decaissement $decaissment
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_transaction', 'montant', 'decaissment_id'], 'required'],
            [['date_transaction'], 'safe'],
            [['montant'], 'number'],
            [['decaissment_id'], 'integer'],
            [['decaissment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Decaissement::className(), 'targetAttribute' => ['decaissment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
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
     * Gets query for [[Decaissment]].
     *
     * @return \yii\db\ActiveQuery|DecaissementQuery
     */
    public function getDecaissment()
    {
        return $this->hasOne(Decaissement::className(), ['id' => 'decaissment_id']);
    }

    /**
     * {@inheritdoc}
     * @return TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }
}
