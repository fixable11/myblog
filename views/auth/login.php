<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use Yii;

$this->title = 'Логин';
$this->params['breadcrumbs'][] = $this->title;
$app_id = Yii::$app->params['fb_app_id'];
$redirect_uri = Yii::$app->params['fb_redirect_uri'];

$session = Yii::$app->session;
if(!$session->isActive){
  $session->open();
}
if(!$session->has('state')){
  $state = Yii::$app->security->generateRandomString();
  $session->set('state', $state);
}
$state = $session->get('state');

?>
<section class="login">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="login__title"><?= Html::encode($this->title) ?></h1>
        <p class="login__desc">Пожалуйста, заполните следующие поля для входа:</p>
      </div>
      <div class="col-lg-4">
        <?php
        $form = ActiveForm::begin([
            'id' => 'loginForm',
            'options' => ['class' => 'login__form'],
        ]);
        ?>

        <?= $form->field($model, 'email', [
            'inputOptions' => ['class' => 'form-control login__input'],
            'labelOptions' => ['class' => 'control-label login__label'],
        ])->textInput(['autofocus' => true])
        ?>

        <?= $form->field($model, 'password',[
            'inputOptions' => ['class' => 'form-control login__input'],
            'labelOptions' => ['class' => 'control-label login__label'],
        ])->passwordInput(['autofocus' => true])->label('Пароль:') ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'class' => 'login__checkbox',
            'autofocus' => true,
            'label' => 'Запомнить',
            'labelOptions' => [
                'class' => 'login__checkboxLabel',
            ]
        ]) ?>
        
        <div class="login__restore">
          Если вы забыли пароль, то вы можете <?= Html::a('восстановить его', 
          ['auth/request-password-reset'], 
          ['class' => 'login__restoreLink']) ?>.
        </div>

        <div class="login__formGroup">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary login__submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
      <div class="w-100"></div>
      <div class="col-lg-5">
        <div class="login__bySocials loginBySocials">
          <div class="loginBySocials__title">Войти через:</div>
          <ul class="loginBySocials__ul">
            <li class="loginBySocials__li">
              <a href="https://www.facebook.com/v3.1/dialog/oauth?client_id=<?=$app_id;?>&redirect_uri=<?=$redirect_uri;?>&state=<?=$state;?>" class="loginBySocials__fb">
                <i class="fab fa-facebook loginBySocials__fbIcon"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

