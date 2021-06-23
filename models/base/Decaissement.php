<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "decaissement".
 *
 * @property integer $id
 * @property string $date_demande
 * @property string $montant
 * @property string $motif
 * @property string $piece_jointe
 * @property integer $status_user
 * @property integer $status_admin
 * @property integer $user_id
 *
 * @property \app\models\User $user
 * @property \app\models\Transaction[] $transactions
 */
class Decaissement extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_demande', 'montant', 'motif', 'piece_jointe', 'status_user', 'status_admin', 'user_id'], 'required'],
            [['date_demande'], 'safe'],
            [['montant'], 'number'],
            [['status_user', 'status_admin', 'user_id'], 'integer'],
            [['motif', 'piece_jointe'], 'string', 'max' => 255],
            [['date_demande'], 'unique'],
         //   [['lock'], 'default', 'value' => '0'],
         //   [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'decaissement';
    }

    /**
     * 
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock 
     * 
     */
    public function optimisticLock() {
      ///  return 'lock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_demande' => 'Date Demande',
            'montant' => 'Montant',
            'motif' => 'Motif',
            'piece_jointe' => 'Piece Jointe',
            'status_user' => 'Status User',
            'status_admin' => 'Status Admin',
            'user_id' => 'User ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(\app\models\Transaction::className(), ['decaissment_id' => 'id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
  
    /**
     * @inheritdoc
     * @return \app\models\DecaissementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\DecaissementQuery(get_called_class());
    }
}
