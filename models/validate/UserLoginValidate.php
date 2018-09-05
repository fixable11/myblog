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
  
  public function codeValidate($code)
  {
    if(!isset($code)){
      throw new HttpException(400, 'Отсутствуют необходимые параметры!');
    }
  }
  
  public function checkUserByEmail($email)
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
