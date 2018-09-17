<?php

/* @var $this \yii\web\View */
/* @var $articles array|ActiveQuery[] */

use yii\helpers\Url;

$timezoneoffset = $_COOKIE['timezoneoffset'] ?? 0;

?>
<section class="posts">
  <?php foreach ($articles as $article): ?>
    <article class="post">
      <div class="post__imgWrap">
        <a class="post__imgWrapLink" href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><img class="post__img" src="<?= $article->getImage(); ?>" alt="post"></a>
        <a class="post__overlay" href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>">
          <i class="fas fa-eye post__eye"></i>
        </a>
      </div>
      <div class="post__content">
        <header class="post__titles">
          <h6 class="h6 post__titleCategory"><a class="post__titleCategoryLink" href="<?= Url::toRoute(['site/category', 'id' => $article->category->id ?? '#']) ?>"><?= $article->category->title ?? 'Категория не определена' ?></a></h6>
          <h2 class="h2 post__titlePost"><a class="posts__titlePostLink" href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"> <?= $article->title; ?></a></h2>
        </header>
        <div class="post__descBlock">
          <p class="post__desc"><?= Yii::$app->common->getShort($article->description); ?></p>
            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="post__continue">Далее</a>
        </div>
        <div class="post__social">
          <div class="post__identity">
            <a href="#" class="post__identityLeft">
              <img src="<?= $article->author->image; ?>" alt="thumbnail" class="post__thumbnail">
            </a>
            <div class="post__identityRight">
              <a href="#" class="post__author"><?= $article->author->username; ?> <?= $article->author->last_name; ?></a> 
              <span class="post__date"><?= $article->getDate($timezoneoffset); ?></span>
            </div>
          </div>
          <ul class="post__socialIcons">
            <li class="post__socialOne"><i class="post__socialIcon fas fa-comments"></i><span class="post__socialText"><?= $article->getComments()->count() ?></span></li>
            <li class="post__socialOne"><i class="post__socialIcon fa fa-eye"></i><span class="post__socialText"><?= (int) $article->viewed; ?></span></li>
            <li class="post__socialOne"><i class="post__socialIcon fas fa-thumbs-up"></i><span class="post__socialText"><?= $article->like_up; ?></span></li>            
            <li class="post__socialOne"><i class="post__socialIcon fas fa-thumbs-down"></i><span class="post__socialText"><?= $article->like_down; ?></span></li>            
          </ul>
        </div>
      </div>
    </article>
  <?php endforeach; ?>
</section>