<?php

namespace pso\yii2\user\models;

use pso\yii2\user\interfaces\PasswordInterface;
use Yii;
use yii\web\IdentityInterface;
use yii\base\InvalidCallException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string|null $is_system
 * @property string $type_id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $auth_key
 * @property int $verified
 * @property int $auto
 * @property string $status
 * @property string|null $last_login
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AuthToken[] $authTokens
 * @property Profile $profile
 * @property UserType $type
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface, PasswordInterface
{
    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";
    const STATUS_DELETED = "deleted";
    const STATUS_BLOCKED = "blocked";
    const VERIFIED_YES = 1;
    const VERIFIED_NO = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['!is_system', '!status'], 'string'],
            [['type_id'], 'required'],
            [['!verified', '!auto'], 'integer'],
            [['last_login', 'created_at', 'updated_at'], 'safe'],
            [['type_id', 'username'], 'string', 'max' => 40],
            [['!password', '!auth_key'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['is_system'], 'unique'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_system' => 'Is System',
            'type_id' => 'Type ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'verified' => 'Verified',
            'auto' => 'Auto',
            'status' => 'Status',
            'last_login' => 'Last Login',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AuthTokens]].
     *
     * @return \yii\db\ActiveQuery|\pso\yii2\user\models\query\AuthTokenQuery
     */
    public function getAuthTokens()
    {
        return $this->hasMany(AuthToken::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery|\pso\yii2\user\models\query\ProfileQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery|\pso\yii2\user\models\query\UserTypeQuery
     */
    public function getType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'type_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password = NULL)
    {
        if(is_null($password) || !empty($password)){
            $this->password = '';
        }
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::find()
        ->with(['profile'])
        ->where(['id' => $id, 'status' => self::STATUS_ACTIVE])
        ->one();
    }

    /**
     * {@inheritdoc}
     */
    public static function findByUsername($id)
    {
        return static::find()->profile()->username($id)->one();
    }

    public static function findByEmail(string $email){
        if(is_null($email)){
            return NULL;
        }
        return static::find()->profile()->where(['profile.email' => $email])->one();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findSystemUser(){
        $user = static::find()->where(['is_system' => '1'])->one();
        if(is_null($user)){
            throw new InvalidCallException('No system user found');
        }
        return $user;
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \pso\yii2\user\models\query\UserQuery(get_called_class());
    }

    public static function instantiate($row)
    {
        return \Yii::createObject(get_called_class());
    }
}
