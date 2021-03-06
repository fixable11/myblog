<?php

namespace app\models;

use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\models\validate\UserLoginValidate;
use yii\helpers\ArrayHelper;
use app\models\AuthAssignment;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $isAdmin
 * @property string $photo
 *
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    
    const ADMIN_STATUS = 1;
    const USER_STATUS = 0;
    
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_USER = 'user';
    
    public $roles;
  
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['roles', 'safe'],
            [['isAdmin'], 'default', 'value' => self::USER_STATUS],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'User Name',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
        ];
    }
    
    public function __construct()
    {
      $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'saveRoles']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
      return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }
    
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
      return User::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
      throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $email Email
     * @return array|null
     */
    public static function findByEmail($email)
    {
      return User::find()->where(['email' => $email])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
      return $this->id;
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
     * Saves the assigned attributes to the DB
     * 
     * @return bool Whether the save is successful
     */
    public function create()
    {
      return $this->save();
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
    public function setPassword($password)
    {
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
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
      $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
      if (empty($token)) {
          return false;
      }
      $timestamp = (int) substr($token, strrpos($token, '_') + 1);
      $expire = Yii::$app->params['user.passwordResetTokenExpire'];
      return $timestamp + $expire >= time();
    }
    
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
      $this->password_reset_token = null;
    }
       
    public function saveFromFb($fb_data)
    {
      $required = ['id', 'first_name', 'last_name', 'picture', 'photo_rec', 'email'];
      if (!$this->whetherKeysMatch($fb_data, $required)) {
        return false;
      }
      $userModelValidate = new UserLoginValidate();
      $user_by_email = $userModelValidate->returnUserByEmail($fb_data['email']);

      $user_by_email->username = $fb_data['first_name'];
      $user_by_email->last_name = $fb_data['last_name'];
      $user_by_email->fb_uid = $fb_data['id'];
      $user_by_email->photo = $fb_data['picture']['data']['url'];
      $user_by_email->photo_rec = $fb_data['photo_rec']['data']['url'];
      if(!$user_by_email->save()){
        throw new HttpException(403, 'Ошибка при сохранении пользователя в бд.');
      }
      return Yii::$app->user->login($user_by_email);
    }
    
    
    /**
     * The method compares two arrays for checking the same keys 
     * 
     * @param type $input_array Array to check
     * @param type $required Array of required keys
     * @return boolean
     */
    private function whetherKeysMatch($input_array, $required)
    {
      $count_intersect = count(array_intersect_key(array_flip($required), $input_array));
      if($count_intersect === count($required)){
        return true;
      }
      return false;
    }
    
    /**
     * Gets small user's image
     * 
     * @return string Returns user's image or default image
     */
    public function getImage()
    {
      if($this->photo_rec){
        return $this->photo_rec;
      }  
      return '/' . Yii::$app->params['images_folder'] . '/default-user.png';
    }
    
    /**
     * Gets full user's image
     * 
     * @return string Returns user's full image
     */
    public function getFullImage()
    {
      return $this->photo;
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
      if (!static::isPasswordResetTokenValid($token)) {
          return null;
      }
      return User::findOne([
          'password_reset_token' => $token,
      ]);
    }
    
    /**
     * Gets all existing roles in an array
     * 
     * @return type
     */
    public function getRolesDropdown()
    {
      return [
        self::ROLE_ADMIN => 'Admin',  
        self::ROLE_MODERATOR => 'Moderator',  
        self::ROLE_USER => 'User',  
      ];
    }
    
    /**
     * Saves roles before update
     */
    public function saveRoles()
    {
      Yii::$app->authManager->revokeAll($this->getId());
      foreach ($this->roles as $roleName){
        if($role = Yii::$app->authManager->getRole($roleName)){
          Yii::$app->authManager->assign($role, $this->getId());
        }
      }
      
    }
    
    /*
     * Populate roles attribute with data from RBAC after record loaded from DB
     */
    public function afterFind()
    {
      parent::afterFind();
      $this->roles = $this->getRoles();
    }
    
    /**
     * Returns user's roles that have been assigned to it
     * 
     * @return array
     */
    public function getRoles()
    {
      $roles = Yii::$app->authManager->getRolesByUser($this->getId());
      return ArrayHelper::getColumn($roles, 'name', false);
    }
    
    /**Relation links user by user_id with 'auth_assignment' table
     * 
     * 
     * @return ActiveQuery
     */
    public function getRelatedRoles()
    {
      return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

}
