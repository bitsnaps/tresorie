<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property int $user_id
 * @property int $role_id
 * @property string $niveau
 * @property float $montant
 *
 * @property User $user
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id', 'niveau', 'montant'], 'required'],
            [['user_id', 'role_id'], 'integer'],
            [['montant'], 'number'],
            [['niveau'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Utilisateur',
            'role_id' => 'Role',
            'niveau' => 'Niveau',
            'montant' => 'Montant',
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
}
