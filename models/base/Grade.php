<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "grade".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $role_id
 * @property string $niveau
 * @property string $montant
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property \app\models\User $user
 */
class Grade extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id', 'niveau', 'montant'], 'required'],
            [['user_id', 'role_id', 'updated_at', 'created_at'], 'integer'],
            [['montant'], 'number'],
            [['niveau'], 'string', 'max' => 255],
            //[['lock'], 'default', 'value' => '0'],
           // [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * 
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock 
     * 
     */
    public function optimisticLock() {
        return 'lock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Nom d\'utilisateur',
            'role_id' => 'Role',
            'niveau' => 'Niveau',
            'montant' => 'Montant',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id'])->inverseOf('grades');
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
           
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\GradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\GradeQuery(get_called_class());
    }
}
