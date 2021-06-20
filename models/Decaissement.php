<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "decaissement".
 *
 * @property int $id
 * @property string $date_demande
 * @property float $montant
 * @property string $motif
 * @property string $piece_jointe
 * @property int $status
 * @property int $user_id
 *
 * @property User $user
 * @property Transaction[] $transactions
 */
class Decaissement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'decaissement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_demande', 'montant', 'motif', 'piece_jointe', 'status', 'user_id'], 'required'],
            [['date_demande'], 'safe'],
            [['montant'], 'number'],
            [['status', 'user_id'], 'integer'],
            [['motif', 'piece_jointe'], 'string', 'max' => 255],
            [['date_demande'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_demande' => 'Date Demande',
            'montant' => 'Montant',
            'motif' => 'Motif',
            'piece_jointe' => 'Piece Jointe',
            'status' => 'Status',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['decaissment_id' => 'id']);
    }
}
