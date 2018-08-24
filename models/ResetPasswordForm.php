<?php

namespace app\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use app\models\User;
use yii\web\NotFoundHttpException;
/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_2;
    /**
     * @var \common\models\User
     */
    private $_user;
    
    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            //throw new InvalidArgumentException('Wrong password reset token.');
            throw new NotFoundHttpException();
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'password_2'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_2', 'string', 'min' => 6],
            ['password_2', 'validatePassword'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'password_2' => 'Повторите пароль',
        ];
    }
    
    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
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