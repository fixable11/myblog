<?php

namespace app\models\validate;

use Yii;
use app\models\User;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
/**
 * Description of UserLoginValidate
 *
 * @author Никита
 */
class UserLoginValidate
{
  
  /**
   * It checks whether user's token valid
   * 
   * @param string $user_token user's token
   * @return bool
   * @throws NotFoundHttpException
   */
  public function whetherUserTokenValid($user_token)
  {
    $params = array(
        'input_token' => $user_token,
        'access_token' => Yii::$app->params['fb_app_token'],
       );
    $token_link = "https://graph.facebook.com/debug_token?" . http_build_query($params);
    $token_valid = json_decode(file_get_contents($token_link));
    if(!$token_valid){
      throw new NotFoundHttpException('Ошибка обработки запроса!');
    } else {
      return $token_valid->data->is_valid;
    }
  }
  
  /**
   * It checks whether user's authentication code valid
   * 
   * @param type $state Session state
   * @throws NotFoundHttpException
   */
  public function stateValidate($state)
  {
    $session = Yii::$app->session;
    if(isset($state) && strlen($state) == 32 && $session->has('state')){
        if($session->get('state') != $state){
          throw new NotFoundHttpException('Ошибка обработки запроса!');
        }
    } else {
      throw new NotFoundHttpException('Ошибка обработки запроса!');
    }
  }
  
  /**
   * Checks whether exists code for retrieving access token
   * 
   * @param type $code Code that has been returned by facebook
   * @throws HttpException
   */
  public function codeValidate($code)
  {
    if(!isset($code)){
      throw new HttpException(400, 'Отсутствуют необходимые параметры!');
    }
  }
  
  /**
   * Checks whether user has already registered
   * 
   * @param type $email User's email
   * @return yii\db\ActiveRecord $user User's model
   * @throws NotFoundHttpException
   */
  public function returnUserByEmail($email)
  {
    $user = User::findOne(['email' => $email]);
    if($user){
      return $user;
    } else {
      throw new NotFoundHttpException('На сайте нет аккаунтов, удовлетворяющих данному способу входа. '
        . 'Если Вы еще не зарегистрированы, пожалуйста, сначала пройдите регистрацию. ');
    }
  }
  
}
