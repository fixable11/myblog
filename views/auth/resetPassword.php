<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Смена пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="resetPassword">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="resetPassword__title"><?= Html::encode($this->title) ?></h1>
        <p class="resetPassword__desc">Пожалуйста, выберите новый пароль:</p>
      </div>
      <div class="col-lg-4">
        <?php
        $form = ActiveForm::begin([
            'id' => 'resetPasswordForm',
            'options' => ['class' => 'resetPassword__form'],
        ]);
        ?>

        <?= $form->field($model, 'password', [
            'inputOptions' => ['class' => 'form-control resetPassword__input'],
            'labelOptions' => ['class' => 'control-label resetPassword__label'],
        ])->passwordInput(['autofocus' => true])->label('Пароль:') ?>
        
        <?= $form->field($model, 'password_2', [
            'inputOptions' => ['class' => 'form-control resetPassword__input'],
            'labelOptions' => ['class' => 'control-label resetPassword__label'],
        ])->passwordInput(['autofocus' => true])->label('Повторите пароль:') ?>

        <div class="resetPassword__formGroup">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary resetPassword__submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>