<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
/* @var $selectedCategory app\models\Category */
/* @var $categories app\models\Category */
/* @var $selectedTags app\models\Tag */
/* @var $tags app\models\Tag */
?>

<div class="article-form articleForm">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255, 'class' => 'form-control articleForm__input']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'class' => 'form-control articleForm__textarea']) ?>
    <div class="articleForm__ckeditor">  
      <?=
      $form->field($model, 'content')->widget(CKEditor::className(), [
          'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
              'preset' => 'full',
              'language' => 'ru',  
              'inline' => false,
          ]),
      ]);
      ?>
    </div>
    <?php if(isset($selectedCategory)): ?>
      <div class="articleForm__categories">
        <div class="articleForm__categoriesLabel">Categories</div>
        <?= Html::dropDownList('category', $selectedCategory, $categories,
                    ['class' => 'form-control articleForm__category']); ?>
      </div>
    <?php endif; ?>
    <?php if(isset($selectedCategory)): ?>
      <div class="articleForm__tags">
        <div class="articleForm__tagsLabel">Tags</div>
        <?= Html::dropDownList('tags', $selectedTags, $tags, [
            'class' => 'form-control CategoryViewForm__select', 
            'multiple' => true
            ]);
        ?>
      </div>
    <?php endif; ?>
  
    <?= $form->field($model, 'image')->fileInput(['maxlength' => true, 'class' => 'form-control articleForm__input']) ?>
    
    <div class="articleForm__curImgWrap">
      <div class="articleForm__curImgLabel">Current image</div>
      <img src="<?= $model->getImage(); ?>" alt="img" class="articleForm__curImg">
    </div>
  
    <?= $form->field($model, 'date')->textInput(['class' => 'form-control articleForm__input'])->hint('Поле не обязательно к заполнению (будет взята текущая дата). Формат: Y-m-d H:i:s') ?>

    <div class="form-group formGroup">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success articleForm__btnSave']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
