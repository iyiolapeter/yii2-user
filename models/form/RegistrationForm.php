<?php

namespace pso\yii2\user\models\form;

use yii\base\Model;
use pso\yii2\user\models\User;
use pso\yii2\user\models\Profile;

class RegistrationForm extends Model
{
    public $type_id; 
    public $username;
    public $password;
    public $confirm_password;

    private $_profile;

    public function rules(){
        return [
            [['type_id','username','password','confirm_password'], 'required'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password'],
        ];
    }

    public function setProfile(Profile $profile){
        $this->_profile = $profile;
    }

    public function getProfile(){
        return $this->_profile;
    }

    public function save(){
        if(!$this->validate()){
            return false;
        }
        if(!$this->_profile){
            $this->setProfile(new Profile());
        }
        $user = new User();
        $user->setAttributes($this->getAttributes());
        $user->type_id = $this->type_id;
        $user->setPassword($this->password);
        $user->status = User::STATUS_ACTIVE;
        $user->generateAuthKey();
        if(!$user->validate()){
            $this->addErrors($user->getErrors());
            return false;
        }
        if(!$user->save(false)){
            return false;
        }
        try {
            $user->link('profile', $this->profile);
        } catch (\Throwable $th) {
            $user->delete();
            return false;
        }
        return true;
    }


}