<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\widgets\Sidebar;

$this->title = 'Теги';

$timezoneoffset = $_COOKIE['timezoneoffset'] ?? 0;

?>
<div class="tags">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h3 class="h3 tags__title">Поиск по тегу "<?= $tagName ?>"</h3>
        <?php if(count($articles) != 0): ?>
          <?php foreach ($articles as $article): ?>
            <article class="tags__article">
              <div class="row no-gutters">
                <div class="col-md-5">
                  <div class="tags__articleLeft">
                    <div class="tags__articleImgWrap">
                      <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><img class="tags__articleImg" src="<?= $article->getImage(); ?>" alt="post"></a>
                      <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="tags__articleOverlay">
                        <i class="fas fa-eye tags__articleEye"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="tags__articleRight">
                    <div class="tags__content">
                      <h3 class="h3 tags__titleArticle">
                        <a class="tags__titleArticleLink" href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"> <?= $article->title; ?></a>
                      </h3>
                      <p class="tags__desc"><?= Yii::$app->common->getShort($article->description, 100); ?></p>
                      <div class="tags__social">
                        <div class="tags__identity">
                          <div class="tags__identityLeft">
                            <a href="#" class="tags__identityAuthorImgWrap">
                              <img src="<?= $article->author->image; ?>" alt="thumbnail image" class="tags__thumbnail">
                            </a>
                            <a href="#" class="tags__identityAuthorLink"><?= $article->author->username; ?> <?= $article->author->last_name; ?></a> 
                          </div>
                          <div class="tags__identityRight">
                            <span class="tags__articleDate" data-timestamp=""><?= $article->getDate($timezoneoffset); ?></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
          <ul class="pagination">
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
                'disabledPageCssClass' => '',
            ]);
            ?>
          </ul>
        <?php else: ?>
          <div class="tags__noData">Извините, но статей по данному тегу не найдено.</div>
        <?php endif; ?>
      </div>
      <div class="col-lg-4" data-sticky_column>
        <?=
        Sidebar::widget([
            'recent' => $recent,
            'categories' => $categories,
            'subModel' => $subModel,
            'tags' => $tags,
        ]);
        ?>
      </div>
    </div>
  </div>
</div>