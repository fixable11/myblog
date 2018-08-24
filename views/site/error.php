<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="error">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="error__wrap">
          <h1 class="error__title"><?= Html::encode($this->title) ?></h1>
          <?php if ($message): ?>
            <div class="alert alert-danger error__alert"><?= nl2br(Html::encode($message)) ?></div>
          <?php else: ?>
            <div class="alert alert-danger error__alert">Страница не найдена</div>
          <?php endif; ?>
          <p class="error__desc">Ошибка произошла при попытке веб-сервера обработать ваш запрос.</p>
          <p class="error__desc">Свяжитесь с нами если вы уверены, что ошибка исходит со стороны сервера. Спасибо.</p>
        </div>
      </div>
    </div>
  </div>
</div>
