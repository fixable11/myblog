<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\widgets\Sidebar;

$this->title = 'Категории';

$timezoneoffset = $_COOKIE['timezoneoffset'] ?? 0;

?>
<div class="categories">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h3 class="h3 categories__title">Поиск по категории "<?= $categoryName ?>"</h3>
        <?php if(count($articles) != 0): ?>
          <?php foreach ($articles as $article): ?>
            <article class="categories__article">
              <div class="row no-gutters">
                <div class="col-md-5">
                  <div class="categories__articleLeft">
                    <div class="categories__articleImgWrap">
                      <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><img class="categories__articleImg" src="<?= $article->getImage(); ?>" alt="post"></a>
                      <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="categories__articleOverlay">
                        <i class="fas fa-eye categories__articleEye"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="categories__articleRight">
                    <div class="categories__content">
                      <h3 class="h3 categories__titleArticle">
                        <a class="categories__titleArticleLink" href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"> <?= $article->title; ?></a>
                      </h3>
                      <p class="categories__desc"><?= Yii::$app->common->getShort($article->description, 100); ?></p>
                      <div class="categories__social">
                        <div class="categories__identity">
                          <div class="categories__identityLeft">
                            <a href="#" class="categories__identityAuthorImgWrap">
                              <img src="<?= $article->author->image; ?>" alt="thumbnail image" class="categories__thumbnail">
                            </a>
                            <a href="#" class="categories__identityAuthorLink"><?= $article->author->username; ?> <?= $article->author->last_name; ?></a> 
                          </div>
                          <div class="categories__identityRight">
                            <span class="categories__articleDate" data-timestamp=""><?= $article->getDate($timezoneoffset); ?></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
          <div class="category__pagination">
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
                'disabledPageCssClass' => '',
            ]);
            ?>
          </div>
        <?php else: ?>
          <div class="categories__noData">Извините, но статей по данной категории не найдено.</div>
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