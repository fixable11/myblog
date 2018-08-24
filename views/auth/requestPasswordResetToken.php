<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Запрос на восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="requestPasswordReset">
  <div class="container">
    <div class="row">
      <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="col-lg-12">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p class="mainContent__successText"><?= Yii::$app->session->getFlash('error'); ?></p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      <?php endif; ?>
      <div class="col-lg-12">
        <h1 class="requestPasswordReset__title h1"><?= Html::encode($this->title); ?></h1>
        <p class="requestPasswordReset__desc">Пожалуйста, введите свой email! Туда будет отправлена инструкция по восстановлению пароля!</p>
      </div>
      <div class="col-lg-4">
        <?php
        $form = ActiveForm::begin([
            'id' => 'requestPasswordResetForm',
            'options' => ['class' => 'requestPasswordReset__form'],
        ]);
        ?>

        <?= $form->field($model, 'email', [
            'inputOptions' => ['class' => 'form-control requestPasswordReset__input'],
            'labelOptions' => ['class' => 'control-label requestPasswordReset__label'],
        ])->textInput(['autofocus' => true])->label(true) ?>

        <div class="requestPasswordReset__formGroup">
          <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary requestPasswordReset__submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</section>