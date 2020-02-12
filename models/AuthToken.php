<?php

namespace pso\yii2\user\models;

use Yii;

/**
 * This is the model class for table "{{%auth_token}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $type
 * @property string $token
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class AuthToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%auth_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'integer'],
            [['type', 'token'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['token'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'type' => 'Type',
            'token' => 'Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\pso\yii2\user\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\query\AuthTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \pso\yii2\user\models\query\AuthTokenQuery(get_called_class());
    }
}
