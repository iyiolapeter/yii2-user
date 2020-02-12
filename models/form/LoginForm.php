<?php

namespace pso\yii2\user\models\form;

use yii\base\Model;
use yii\web\IdentityInterface;
use yii\validators\EmailValidator;

class LoginForm extends Model
{
    const SCENARIO_EMAIL = 'email';

    public $username;
    public $password;
    public $rememberMe = true;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            ['username', 'email', 'on'=> [SELF::SCENARIO_EMAIL]],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function behaviors()
    {
        return [
            \pso\yii2\user\behaviors\IdentityBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        $labels = [
            'password' => 'Password',
            'rememberMe' => 'Remember Me'
        ];
        if($this->scenario === SELF::SCENARIO_DEFAULT){
            $labels['username'] = 'Username';
        } elseif ($this->scenario === SELF::SCENARIO_EMAIL){
            $labels['username'] = 'Email';
        }
        return $labels;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function authenticate()
    {
        if ($this->validate()) {
            return static::login($this->getUser(), $this->rememberMe);
        }
        
        return false;
    }

    public static function login(IdentityInterface $user, $remember = false){
        return \Yii::$app->user->login($user, $remember ? 3600 * 24 * 30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     */
    protected function getUser()
    {
        $method = NULL;
        switch($this->scenario){
            case SELF::SCENARIO_DEFAULT:
                $method = 'findByUsername';
            break;
            case SELF::SCENARIO_EMAIL:
                $method = 'findByEmail';
            break;
            default:
                return NULL;
        }
        return call_user_func_array([$this->identityClass, $method],[$this->username]);
    }


}