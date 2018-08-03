<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username'], 'string'],
            [['email'], 'email'],
            [['username'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'username'],
            [['email'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email'],
        ];
    }
    
    public function register()
    {
        if($this->validate()){
            $user = new User(); 
            $user->attributes = $this->attributes;
            return $user->create();
        }
    }
    
}
