<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \app\models\AuthAssignment[] $authAssignments
 * @property \app\models\AuthRule $ruleName
 * @property \app\models\AuthItemChild[] $authItemChildren
 */
class AuthItem extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
         //   [['type', 'created_at', 'updated_at'], 'integer'],
         //   [['description', 'data'], 'string'],
       //     [['name', 'rule_name'], 'string', 'max' => 64],
           // [['lock'], 'default', 'value' => '0'],
           // [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
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
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(\app\models\AuthAssignment::className(), ['item_name' => 'name']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(\app\models\AuthRule::className(), ['name' => 'rule_name']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(\app\models\AuthItemChild::className(), ['child' => 'name']);
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
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_at',
                'updatedByAttribute' => 'updated_at',
            ],
            
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\AuthItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\AuthItemQuery(get_called_class());
    }
}
