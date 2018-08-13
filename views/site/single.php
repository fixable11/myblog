<?php
/* @var $this yii\web\View */
/* @var $article app\models\Article */
/* @var $comments app\models\Article */
/* @var $commentForm app\models\CommentForm */
/* @var $popular app\models\Article */
/* @var $recent app\models\Article */
/* @var $categories app\models\Category */

use yii\helpers\Url;
use app\widgets\Sidebar;
use app\widgets\Comment;

$this->title = 'single post';
?>
<section class="single">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="singleWrap">
          <article class="single__post">
            <div class="single__content">
              <header class="single__header">
                <ul class="single__breadcrumbTrail">
                  <li class="single__breadcrumb"><a href="#" class="single__breadcrumb">Главная</a></li>
                  <li class="single__breadcrumb">/</li>
                  <li class="single__breadcrumb"><a class="single__breadcrumLink" href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"> <?= $article->category->title; ?></a></li>
                </ul>
                <h1 class="single__title"><?= $article->title; ?></h1>


              </header>
              <div class="single__text">
                <?= $article->content; ?>
              </div>
              <div class="decoration">
                <a href="#" class="btn btn-default">Decoration</a>
                <a href="#" class="btn btn-default">Decoration</a>
              </div>

              <div class="social-share">
                <span class="social__date" data-timestamp="<?= strtotime($article->getDate()); ?>"><?= $article->getDate(); ?></span>
                <ul class="text-center pull-right">
                </ul>
              </div>
            </div>
          </article>
          <?=
          Comment::widget([
            'article' => $article,
            'comments' => $comments,
            'commentForm' => $commentForm,
          ]);
          ?>
        </div>
      </div>
      <div class="col-lg-4" data-sticky_column>
        <?=
        Sidebar::widget([
          'popular' => $popular,
          'recent' => $recent,
          'categories' => $categories,
          'subModel' => $subModel
        ]);
        ?>
      </div>
    </div>
  </div>
</section>