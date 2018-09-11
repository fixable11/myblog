<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form userForm">
  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'roles')->checkboxList($model->getRolesDropdown(), [
      'class' => 'userForm__formGroup',
  ]) ?>

  <div class="form-group user__formGroup">
      <?= Html::submitButton('Save', ['class' => 'btn btn-success user__btnSubmit']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>
