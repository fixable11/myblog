<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form categoryForm">
  <?php $form = ActiveForm::begin(); ?>
  <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'class' => 'form-control categoryForm__input']) ?>
  
  <div class="form-group categoryForm__formGroup">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success categoryForm__btnSubmit']) ?>
  </div>
  
  <?php ActiveForm::end(); ?>
</div>
