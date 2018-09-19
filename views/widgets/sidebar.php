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
  <aside class="widget primarySidebar__subscribeWidget">
    <div class="row">
      <div class="col-lg-12">
        <div class="primarySidebar__subsribe subscribeWidget">
          <h5 class="subscribeWidget__title h5">Подписка</h5>
          <?php $form = ActiveForm::begin([
              'options' => ['class' => 'subscribeWidget__form']
            ]) ?>
          <?= $form->field($subModel, 'name')->textInput(['placeholder' => "Введите ваше имя!", 'class' => 'form-control subscribeWidget__inputName'])->label('Имя:'); ?>
          <?= $form->field($subModel, 'email')->textInput(['placeholder' => "Введите ваш email!", 'class' => 'form-control subscribeWidget__inputEmail'])->label('Email'); ?>
          <?= Html::submitButton('Подписаться', ['class' => 'btn subscribeWidget__btn']) ?>
          <?php ActiveForm::end() ?>
        </div>
      </div>
    </div>
  </aside>
  <aside class="widget primarySidebar__freshRecordsWidget">
    <div class="row"> 
      <div class="col-lg-12">
        <div class="freshRecordsWidget">
          <h3 class="freshRecordsWidget__title h5">Свежие записи</h3>
          <ul class="freshRecordsWidget__ul">
            <?php foreach ($recent as $article): ?>
              <li class="freshRecordsWidget__one">
                <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="freshRecords__link"><?= $article->title; ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </aside>
  <aside class="widget primarySidebar__categoriesWidget">
    <div class="row">
      <div class="col-lg-12">
        <div class="categoriesWidget">
          <h3 class="categoriesWidget__title h5">Категории</h3>
          <ul class="categoriesWidget__ul">
            <?php $cnt = count($categories); $i = 0; ?>
            <?php foreach ($categories as $category): ?>
              <li class="categoriesWidget__one">
                <a href="<?= Url::toRoute(['site/category', 'id' => $category->id]); ?>" class="categoriesWidget__link"><?= $category->title; ?> (<?= $category->getArticlesCount(); ?>)</a>
                <?php if($i != $cnt - 1): ?> 
                  <span class="categoriesWidget__comma">,</span>
                <?php endif; ?>
              </li>
              <?php $i++; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </aside>
  <aside class="widget primarySidebar__tagsWidget">
    <div class="row">
      <div class="col-lg-12">
        <div class="tagsWidget">
          <h3 class="tagsWidget__title h5">Теги</h3>
          <ul class="tagsWidget__ul">
            <?php foreach ($tags as $tag): ?>
              <li class="tagsWidget__one">
                <a href="<?= Url::toRoute(['site/tags/' . $tag->title]); ?>" class="tagsWidget__link"><?= $tag->title; ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </aside>
</div>