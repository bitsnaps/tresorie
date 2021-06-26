<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "decaissementhistorique".
 *
 * @property int $id
 * @property string $date_demande
 * @property float $montant
 * @property string $motif
 * @property string $piece_jointe
 * @property int $status_user
 * @property int $status_admin
 * @property int $user_id
 *
 * @property User $user
 * @property Notifications[] $notifications
 */
class Decaissementhistorique extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'decaissementhistorique';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_demande', 'montant', 'motif', 'piece_jointe', 'user_id'], 'required'],
            [['date_demande'], 'safe'],
            [['montant'], 'number'],
            [['status_user', 'status_admin', 'user_id'], 'integer'],
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
            'status_user' => 'Status User',
            'status_admin' => 'Status Admin',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|Da\User\Query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery|NotificationsQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::className(), ['decaissementhistorique_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DecaissementhistoriqueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DecaissementhistoriqueQuery(get_called_class());
    }
}
