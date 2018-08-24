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
    
    public function actionLoginVk($uid, $first_name, $last_name, $photo, 
    $photo_rec, $hash)
    {
        $app_id = Yii::$app->params['app_id'];
        $secret_key = Yii::$app->params['secret_key'];
        if($hash != md5($app_id . $uid . $secret_key)){
          throw new NotFoundHttpException();
        }
        $user = new User();
        if($user->saveFromVk($uid, $first_name, $last_name, $photo, $photo_rec)){
            return $this->redirect(['site/index']);
        }
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
