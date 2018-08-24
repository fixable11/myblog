<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Логин';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login">
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
      
      <div class="col-lg-12">
        <div class="login__vkWidget">
          <script type="text/javascript" src="https://vk.com/js/api/openapi.js?158"></script>
          <script type="text/javascript">
            VK.init({apiId: <?= Yii::$app->params['app_id']; ?>});
          </script>

          <!-- VK Widget -->
          <div id="vk_auth"></div>
          <script type="text/javascript">
            VK.Widgets.Auth("vk_auth", {"authUrl":"/auth/login-vk"});
          </script>
        </div>
      </div>
      
    </div>
  </div>
</div>
