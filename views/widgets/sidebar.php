<?php

/* @var $this \yii\web\View */
/* @var $popular array|ActiveQuery[] */
/* @var $recent array|ActiveQuery[] */
/* @var $categories array|ActiveQuery[] */
/* @var $subModel app\models\SubscribeForm */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="primarySidebar">
  <aside class="widget">
    <div class="row">
      <div class="col-lg-12">
        <div class="primarySidebar__subsribe subscribe">
          <h5 class="subscribe__title h5">Подписка</h5>
          <?php $form = ActiveForm::begin([
              'options' => ['class' => 'subscribe__form']
            ]) ?>
          <?= $form->field($subModel, 'name')->textInput(['placeholder' => "Введите ваше имя!", 'class' => 'form-control subscribe__inputName'])->label('Имя:'); ?>
          <?= $form->field($subModel, 'email')->textInput(['placeholder' => "Введите ваш email!", 'class' => 'form-control subscribe__inputEmail'])->label('Email'); ?>
          <?= Html::submitButton('Подписаться', ['class' => 'btn subscribe__btn']) ?>
          <?php ActiveForm::end() ?>
        </div>
      </div>
    </div>
  </aside>
  <aside class="widget">
    <div class="row"> 
      <div class="col-lg-12">
        <div class="freshRecords">
          <h3 class="freshRecords__title h5">Свежие записи</h3>
          <ul class="freshRecords__ul">
            <?php foreach ($popular as $article): ?>
              <li class="freshRecords__one">
                <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="freshRecords__link"><?= $article->title; ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </aside>
  <aside class="widget">
    <div class="row">
      <div class="col-lg-12">
        <div class="categories">
          <h3 class="categories__title h5">Категории</h3>
          <ul class="categories__ul">
            <?php $cnt = count($categories); $i = 0; ?>
            <?php foreach ($categories as $category): ?>
              <li class="categories__one">
                <a href="<?= Url::toRoute(['site/category', 'id' => $category->id]); ?>" class="categories__link"><?= $category->title; ?> (<?= $category->getArticlesCount(); ?>)</a>
                <?php if($i != $cnt - 1): ?> 
                  <span class="categories__span">,</span>
                <?php endif; ?>
              </li>
              <?php $i++; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </aside>
  <aside class="widget">
    <div class="row">
      <div class="col-lg-12">
        <div class="tagsWidget">
          <h3 class="tagsWidget__title h5">Теги</h3>
          <ul class="tagsWidget__ul">
            <?php foreach ($categories as $category): ?>
              <li class="tagsWidget__one">
                <a href="<?= Url::toRoute(['site/category', 'id' => $category->id]); ?>" class="tagsWidget__link"><?= $category->title; ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </aside>
</div>