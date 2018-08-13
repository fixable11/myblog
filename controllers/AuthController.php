<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\web\NotFoundHttpException;

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
                return $this->redirect(['auth/login']);
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
}
