<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "decaissementhistorique".
 *
 * @property integer $id
 * @property string $date_demande
 * @property string $montant
 * @property string $motif
 * @property string $piece_jointe
 * @property integer $status_user
 * @property integer $status_admin
 * @property integer $sender_user_id
 * @property integer $reciever_user_id
 *
 * @property \app\models\User $recieverUser
 * @property \app\models\User $senderUser
 * @property \app\models\Notifications[] $notifications
 */
class Decaissementhistorique extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['montant', 'motif'], 'required'],
            [['piece_jointe'], 'file', 'skipOnEmpty' => true, 'extensions' => 'file,pdf'],
            [['date_demande'], 'safe'],
            [['montant'], 'number'],
            [['status_user', 'status_admin', 'sender_user_id', 'reciever_user_id'], 'integer'],
          //  [['motif', 'piece_jointe'], 'string', 'max' => 255],
      //      [['date_demande'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'decaissementhistorique';
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
            'sender_user_id' => 'Sender User ID',
            'reciever_user_id' => 'Reciever User ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecieverUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'reciever_user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSenderUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'sender_user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(\app\models\Notifications::className(), ['decaissementhistorique_id' => 'id'])->inverseOf('decaissementhistorique');
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
     * @return \app\models\DecaissementhistoriqueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\DecaissementhistoriqueQuery(get_called_class());
    }
}
