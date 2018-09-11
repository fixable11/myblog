<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-form tagForm">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'class' => 'form-control tagForm__input']) ?>
    <div class="form-group tagForm__formGroup">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success tagForm__btnSave']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
