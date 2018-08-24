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
    public $password_2;
    
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_2' => 'Повторите пароль',
            'rememberMe' => 'Запомнить',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_2'], 'required'],
            [['username'], 'string'],
            [['username'], 'trim'],
            [['username'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'username'],
            [['email'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email'],
            [['email'], 'email'],
            [['email'], 'trim'],
            [['password'], 'string', 'min' => 6],
            [['password_2'], 'string', 'min' => 6],
            [['password_2'], 'validatePassword'],
        ];
    }
    
    /*
     * Register user
     * 
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if(!$this->validate()){
          return null;
        }
        
        $user = new User(); 
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        if($user->create()){
           return Yii::$app->user->login($user, 3600*24*30);
        }
        
        return null;
    }
    
    /**
     * Validates the password.
     * This method compare two passwords.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
        
            if ($this->password !== $this->password_2) {
                $this->addError($attribute, 'Пароли не совпадают!');
            }
            
        }
    }
    
}
