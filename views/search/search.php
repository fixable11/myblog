<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\widgets\Sidebar;
use yii\helpers\Html;

$this->title = 'Поиск';

$timezoneoffset = $_COOKIE['timezoneoffset'] ?? 0;

?>
<div class="search">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h3 class="h3 search__title">Поиск по запросу "<?= Html::encode($query) ?>"</h3>
        <?php if(count($articles) != 0): ?>
          <?php foreach ($articles as $article): ?>
            <article class="search__article">
              <div class="row no-gutters">
                <div class="col-md-5">
                  <div class="search__articleLeft">
                    <div class="search__articleImgWrap">
                      <img class="search__articleImg" src="<?= $article->getImage(); ?>" alt="post">
                      <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="search__articleOverlay">
                        <i class="fas fa-eye search__articleEye"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="search__articleRight">
                    <div class="search__content">
                      <h3 class="h3 search__titleArticle">
                        <a class="search__titleArticleLink" href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"> <?= $article->title; ?></a>
                      </h3>
                      <p class="search__desc"><?= Yii::$app->common->getShort($article->description, 100); ?></p>
                      <div class="search__social">
                        <div class="search__identity">
                          <div class="search__identityLeft">
                            <a href="#" class="search__identityAuthorImgWrap">
                              <img src="<?= $article->author->image; ?>" alt="thumbnail image" class="search__thumbnail">
                            </a>
                            <a href="#" class="search__identityAuthorLink"><?= $article->author->username; ?> <?= $article->author->last_name; ?></a> 
                          </div>
                          <div class="search__identityRight">
                            <span class="search__articleDate" data-timestamp=""><?= $article->getDate($timezoneoffset); ?></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
          <div class="search__pagination">
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
                'disabledPageCssClass' => '',
            ]);
            ?>
          </div>
        <?php else: ?>
          <div class="search__noData">Извините, но статей по данному запросу не найдено.</div>
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