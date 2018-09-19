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
use app\models\Likes;

$this->title = $article->title;

?>
<section class="single">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="singleWrap">
          <article class="single__post">
              <header class="single__header">
                <ul class="single__breadcrumbTrail">
                  <li class="single__breadcrumb"><a href="<?= Url::home() ?>" class="single__breadcrumb">Главная</a></li>
                  <li class="single__breadcrumb">/</li>
                  <li class="single__breadcrumb"><a class="single__breadcrumLink" href="<?= Url::toRoute(['site/category', 'id' => $article->category->id ?? '#']) ?>"><?= $article->category->title ?? 'Категория не определена' ?></a></li>
                </ul>
                <h1 class="single__title"><?= $article->title; ?></h1>
              </header>
              <div class="single__content">
                <?= $article->content; ?>
              </div>
            <div class="singleSocial">
              <div class="singleSocial__shareWrap">
                <div class="singleSocial__shareText">Понравилось? Нажми поделиться! <i class="fas fa-share singleSocial__shareIcon"></i></div>
                <ul class="singleSocial__ul">
                  <li class="singleSocial__li">
                    <div class="fb-share-button" data-href="" data-layout="button" data-size="large" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A3000%2Fsite%2Fview%3Fid%3D7&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Поделиться</a></div>
                  </li>
                </ul>
              </div>
              <div class="singleSocial__createdWrap">
                <i class="fas fa-user singleSocial__authorIcon"></i>
                <div class="singleSocial__author"><?= $article->author->username ?> <?= $article->author->last_name ?></div>
                <div class="singleSocial__datetime"><?= $article->getDate(); ?></div>
              </div>
              <div class="singleSocial__likesWrap">
                <button data-href="<?= Url::to(['article/like-up', 'article_id' => $article->id]) ?>" class="singleSocial__likeUpButton">
                  <i class="fas fa-thumbs-up singleSocial__likeUp <?php if(Likes::whetherUserLiked($article->id)) echo 'active'; ?>"></i>
                </button>       
                <div class="singleSocial__likeUpCount"><?= $article->like_up ?></div>
                <button data-href="<?= Url::to(['article/like-down', 'article_id' => $article->id]) ?>" class="singleSocial__likeDownButton">
                  <i class="fas fa-thumbs-down singleSocial__likeDown <?php if(Likes::whetherUserDisliked($article->id)) echo 'active'; ?>"></i>
                </button>
                <div class="singleSocial__likeDownCount"><?= $article->like_down ?></div>
                <i class="fas fa-eye singleSocial__viewed"></i>
                <div class="singleSocial__viewedCount"><?= $article->viewed; ?></div>
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
          'subModel' => $subModel,
          'tags' => $tags,
        ]);
        ?>
      </div>
    </div>
  </div>
  <div id="fb-root"></div>
</section>