<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\web\NotFoundHttpException;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use yii\web\HttpException;
use app\models\validate\UserLoginValidate;
use app\models\api\FbApi;

/**
 * Description of AuthController
 *
 * @author Никита
 */
class AuthController extends Controller
{
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }    

        $model->password = '';
        return $this->render('/auth/login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionRegister()
    {
        $model = new RegisterForm();
        
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            if($model->register()){
                return $this->redirect(['/']);
            } 
        }
        
        return $this->render('register', ['model' => $model]);
    }
    
    public function actionLoginFb($code = null, $state = null)
    {
      $userModelValidate = new UserLoginValidate();
      $userModelValidate->stateValidate($state);
      $userModelValidate->codeValidate($code);
      
      $token = $this->getFbUserToken($code);

      if($userModelValidate->whetherUserTokenValid($token)){
        Yii::$app->session->set('temporary_token', $token);
        
        $api_object = new FbApi($token);
        $fb_data = $api_object->getFull();
        
        $user = new User();
        if($user->saveFromFb($fb_data)){
           return $this->redirect(['/']);
        } else {
          throw new HttpException(400, 'Ошибка при входе через facebook');
        }
      } else {
        throw new NotFoundHttpException('Invalid user token');
      }
  
    }
    
    public function getFbUserToken($code)
    {
      $params = array(
          'client_id' => $client_id = Yii::$app->params['fb_app_id'],
          'client_secret' => Yii::$app->params['fb_secret_key'],
          'code' => $code,
          'redirect_uri' => Yii::$app->params['fb_redirect_uri'],
        );
       
      $token = "https://graph.facebook.com/v3.1/oauth/access_token?" . http_build_query($params);
      $token = json_decode(file_get_contents($token));
      if(!$token){
        throw new NotFoundHttpException('Произошла ошибка при входе через facebook!');
      }
      if($token->access_token){
        $token = $token->access_token;
      }
      
      return $token; 
    }
    
    
    
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свой email, где находятся дальнейшие инструкции');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Извините, но мы не можем восстановить пароль для указанного email.');
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
    
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль успешно сохранен.');
            return $this->goHome();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
