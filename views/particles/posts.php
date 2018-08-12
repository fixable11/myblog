<?php

/* @var $this \yii\web\View */
/* @var $articles array|ActiveQuery[] */

use yii\helpers\Url;
?>
<section class="posts">
  <?php foreach ($articles as $article): ?>
    <article class="post">
      <div class="post__imgWrap">
        <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><img class="post__img" src="<?= $article->getImage(); ?>" alt="post"></a>
        <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="post__overlay">
          <i class="fas fa-eye post__eye"></i>
        </a>
      </div>
      <div class="post__content">
        <header class="post__titles">
          <h6 class="h6 post__titleCategory"><a class="post__titleCategoryLink" href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"><?= $article->category->title ?? 'Category is not defined' ?></a></h6>
          <h2 class="h2 post__titlePost"><a class="posts__titlePostLink" href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"> <?= $article->title; ?></a></h2>
        </header>
        <div class="post__descBlock">
          <p class="post__desc"><?= Yii::$app->delimiter->getShort($article->description); ?></p>
            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="post__continue">Далее</a>
        </div>
        <div class="post__social">
          <div class="post__identity">
            <a href="<?php if(isset($article->author->email)) echo '#'; else echo 'https://vk.com/id'.$article->author->id; ?>" class="post__identityLeft">
              <img src="<?= $article->author->photo_rec; ?>" alt="thumbnail image" class="post__thumbnail">
            </a>
            <div class="post__identityRight">
              <a href="<?php if(isset($article->author->email)) echo '#'; else echo 'https://vk.com/id'.$article->author->id; ?>" class="post__author"><?= $article->author->username; ?> <?= $article->author->last_name; ?></a> 
              <span class="post__date" data-timestamp="<?= strtotime($article->getDate()); ?>"><?= $article->getDate(); ?></span>
            </div>
          </div>
          <ul class="post__socialIcons">
            <li class="post__socialOne"><a href="#" class="post__socialLink"><i class="fas fa-comments"></i><span class="post__socialText">33</span></a></li>
            <li class="post__socialOne"><a href="#" class="post__socialLink"><i class="post__socialIcon fa fa-eye"></i><span class="post__socialText"><?= (int) $article->viewed; ?></span></a></li>
            

            
          </ul>
        </div>
      </div>
    </article>
  <?php endforeach; ?>
</section>