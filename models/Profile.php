<?php

namespace pso\yii2\user\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $phone_number
 * @property string|null $email
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $gender
 * @property string|null $dob
 * @property string|null $address
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['gender'], 'string'],
            [['dob', 'created_at', 'updated_at'], 'safe'],
            [['phone_number'], 'string', 'max' => 13],
            [['email', 'first_name', 'last_name', 'address'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['phone_number'], 'unique'],
            [['email'], 'unique'],
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
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'address' => 'Address',
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
     * @return \pso\yii2\user\models\query\ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \pso\yii2\user\models\query\ProfileQuery(get_called_class());
    }

    public static function instantiate($row)
    {
        return \Yii::createObject(get_called_class());
    }
}
