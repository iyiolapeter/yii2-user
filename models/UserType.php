<?php

namespace pso\yii2\user\models;

use Yii;

/**
 * This is the model class for table "{{%user_type}}".
 *
 * @property string $id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User[] $users
 */
class UserType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|\pso\yii2\user\models\query\UserQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\query\UserTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \pso\yii2\user\models\query\UserTypeQuery(get_called_class());
    }

    public static function fetchOptions(){
        return static::find()->select(['name'])->indexBy('id')->column();
    }
}
