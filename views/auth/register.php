<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="register__title"><?= Html::encode($this->title) ?></h1>
        <p class="register__desc">Пожалуйста, заполните поля для регистрации:</p>
      </div>
      <div class="col-lg-4">
        <?php
        $form = ActiveForm::begin([
            'id' => 'registerForm',
            'options' => ['class' => 'register__form'],
        ]);
        ?>
        
        <?= $form->field($model, 'username',[
            'inputOptions' => ['class' => 'form-control register__input'],
            'labelOptions' => ['class' => 'control-label register__label'],
        ])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email',[
            'inputOptions' => ['class' => 'form-control register__input'],
            'labelOptions' => ['class' => 'control-label register__label'],
        ])->textInput() ?>

        <?= $form->field($model, 'password',[
            'inputOptions' => ['class' => 'form-control register__input'],
            'labelOptions' => ['class' => 'control-label register__label'],
        ])->passwordInput()->label('Пароль:') ?>
        
        <?= $form->field($model, 'password_2',[
            'inputOptions' => ['class' => 'form-control register__input'],
            'labelOptions' => ['class' => 'control-label register__label'],
        ])->passwordInput()->label('Повторите пароль:') ?>

        <div class="register__formGroup">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary register__submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>