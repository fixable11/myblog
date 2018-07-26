<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="CategoryView article-form">
    <div class="container">
        <div class="row">
            <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'CategoryViewForm',
                    ],
            ]); ?>
            <div class="col-md-6">
                <?= Html::dropDownList('category', $selectedCategory, $categories,
                ['class' => 'form-control CategoryViewForm__select']); ?>
            </div>
            <div class="col-md-6">
                <div class="CategoryViewForm__submit form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                </div>
            </div>      
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
