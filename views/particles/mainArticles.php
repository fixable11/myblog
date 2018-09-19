<?php
/* @var $this yii\web\View */
/* @var $popular app\models\Article */

use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\widgets\Sidebar;

$timezoneoffset = $_COOKIE['timezoneoffset'] ?? 0;
?>
<?php if (count($popular) == Yii::$app->params['popularLimit']): ?>
  <section class="mainArticles">
    <div class="row">
      <div class="col-lg-6">
        <article class="mainArticle mainArticle_big-one">
          <div class="mainArticle__imgWrap">
            <a class="mainArticle__imgWrapLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"><img class="mainArticle__img" src="<?= $popular[0]->getImage(); ?>" alt="post"></a>
            <a class="mainArticle__overlay" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>">
              <i class="fas fa-eye mainArticle__eye"></i>
            </a>
          </div>
          <div class="mainArticle__content">
            <header class="mainArticle__titles">
              <h6 class="h6 mainArticle__titleCategory"><a class="mainArticle__titleCategoryLink" href="<?= Url::toRoute(['site/category', 'id' => $popular[0]->category->id ?? '#']) ?>"><?= $popular[0]->category->title ?? 'Категория не определена' ?></a></h6>
              <h2 class="h2 mainArticle__titlePost"><a class="posts__titlePostLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"> <?= $popular[0]->title; ?></a></h2>
            </header>
            <div class="mainArticle__descBlock">
              <p class="mainArticle__desc"><?= Yii::$app->common->getShort($popular[0]->description); ?></p>
              <a href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>" class="mainArticle__continue">Далее</a>
            </div>
            <div class="mainArticle__social">
              <div class="mainArticle__identity">
                <a href="#" class="mainArticle__identityLeft">
                  <img src="<?= $popular[0]->author->image; ?>" alt="thumbnail" class="mainArticle__thumbnail">
                </a>
                <div class="mainArticle__identityRight">
                  <a href="#" class="mainArticle__author"><?= $popular[0]->author->username; ?> <?= $popular[0]->author->last_name; ?></a> 
                  <span class="mainArticle__date"><?= $popular[0]->getDate($timezoneoffset); ?></span>
                </div>
              </div>
              <ul class="mainArticle__socialIcons">
                <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-comments"></i><span class="mainArticle__socialText"><?= $popular[0]->getComments()->count() ?></span></li>
                <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fa fa-eye"></i><span class="mainArticle__socialText"><?= (int) $popular[0]->viewed; ?></span></li>
                <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-up"></i><span class="mainArticle__socialText"><?= $popular[0]->like_up; ?></span></li>            
                <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-down"></i><span class="mainArticle__socialText"><?= $popular[0]->like_down; ?></span></li>            
              </ul>
            </div>
          </div>
        </article>
      </div>
      <div class="col-lg-6">
        <div class="row">
          <div class="col-md-6">
            <article class="mainArticle mainArticle_small-one">
              <div class="mainArticle__imgWrap">
                <a class="mainArticle__imgWrapLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"><img class="mainArticle__img" src="<?= $popular[0]->getImage(); ?>" alt="post"></a>
                <a class="mainArticle__overlay" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>">
                  <i class="fas fa-eye mainArticle__eye"></i>
                </a>
              </div>
              <div class="mainArticle__content">
                <header class="mainArticle__titles">
                  <h6 class="h6 mainArticle__titleCategory"><a class="mainArticle__titleCategoryLink" href="<?= Url::toRoute(['site/category', 'id' => $popular[0]->category->id ?? '#']) ?>"><?= $popular[0]->category->title ?? 'Категория не определена' ?></a></h6>
                  <h5 class="h5 mainArticle__titlePost"><a class="posts__titlePostLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"> <?= $popular[0]->title; ?></a></h5>
                </header>
                <div class="mainArticle__descBlock">
                  <p class="mainArticle__desc"><?= Yii::$app->common->getShort($popular[0]->description); ?></p>
                  <a href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>" class="mainArticle__continue">Далее</a>
                </div>
                <div class="mainArticle__social">
                  <div class="mainArticle__identity">
                    <a href="#" class="mainArticle__identityLeft">
                      <img src="<?= $popular[0]->author->image; ?>" alt="thumbnail" class="mainArticle__thumbnail">
                    </a>
                    <div class="mainArticle__identityRight">
                      <a href="#" class="mainArticle__author"><?= $popular[0]->author->username; ?> <?= $popular[0]->author->last_name; ?></a> 
                      <span class="mainArticle__date"><?= $popular[0]->getDate($timezoneoffset); ?></span>
                    </div>
                  </div>
                  <ul class="mainArticle__socialIcons">
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-comments"></i><span class="mainArticle__socialText"><?= $popular[0]->getComments()->count() ?></span></li>
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fa fa-eye"></i><span class="mainArticle__socialText"><?= (int) $popular[0]->viewed; ?></span></li>
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-up"></i><span class="mainArticle__socialText"><?= $popular[0]->like_up; ?></span></li>            
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-down"></i><span class="mainArticle__socialText"><?= $popular[0]->like_down; ?></span></li>            
                  </ul>
                </div>
              </div>
            </article>
          </div>
          <div class="col-md-6">
            <article class="mainArticle mainArticle_small-one">
              <div class="mainArticle__imgWrap">
                <a class="mainArticle__imgWrapLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"><img class="mainArticle__img" src="<?= $popular[0]->getImage(); ?>" alt="post"></a>
                <a class="mainArticle__overlay" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>">
                  <i class="fas fa-eye mainArticle__eye"></i>
                </a>
              </div>
              <div class="mainArticle__content">
                <header class="mainArticle__titles">
                  <h6 class="h6 mainArticle__titleCategory"><a class="mainArticle__titleCategoryLink" href="<?= Url::toRoute(['site/category', 'id' => $popular[0]->category->id ?? '#']) ?>"><?= $popular[0]->category->title ?? 'Категория не определена' ?></a></h6>
                  <h5 class="h5 mainArticle__titlePost"><a class="posts__titlePostLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"> <?= $popular[0]->title; ?></a></h5>
                </header>
                <div class="mainArticle__descBlock">
                  <p class="mainArticle__desc"><?= Yii::$app->common->getShort($popular[0]->description); ?></p>
                  <a href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>" class="mainArticle__continue">Далее</a>
                </div>
                <div class="mainArticle__social">
                  <div class="mainArticle__identity">
                    <a href="#" class="mainArticle__identityLeft">
                      <img src="<?= $popular[0]->author->image; ?>" alt="thumbnail" class="mainArticle__thumbnail">
                    </a>
                    <div class="mainArticle__identityRight">
                      <a href="#" class="mainArticle__author"><?= $popular[0]->author->username; ?> <?= $popular[0]->author->last_name; ?></a> 
                      <span class="mainArticle__date"><?= $popular[0]->getDate($timezoneoffset); ?></span>
                    </div>
                  </div>
                  <ul class="mainArticle__socialIcons">
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-comments"></i><span class="mainArticle__socialText"><?= $popular[0]->getComments()->count() ?></span></li>
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fa fa-eye"></i><span class="mainArticle__socialText"><?= (int) $popular[0]->viewed; ?></span></li>
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-up"></i><span class="mainArticle__socialText"><?= $popular[0]->like_up; ?></span></li>            
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-down"></i><span class="mainArticle__socialText"><?= $popular[0]->like_down; ?></span></li>            
                  </ul>
                </div>
              </div>
            </article>
          </div>
          <div class="col-md-6">
            <article class="mainArticle mainArticle_small-one">
              <div class="mainArticle__imgWrap">
                <a class="mainArticle__imgWrapLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"><img class="mainArticle__img" src="<?= $popular[0]->getImage(); ?>" alt="post"></a>
                <a class="mainArticle__overlay" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>">
                  <i class="fas fa-eye mainArticle__eye"></i>
                </a>
              </div>
              <div class="mainArticle__content">
                <header class="mainArticle__titles">
                  <h6 class="h6 mainArticle__titleCategory"><a class="mainArticle__titleCategoryLink" href="<?= Url::toRoute(['site/category', 'id' => $popular[0]->category->id ?? '#']) ?>"><?= $popular[0]->category->title ?? 'Категория не определена' ?></a></h6>
                  <h5 class="h5 mainArticle__titlePost"><a class="posts__titlePostLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"> <?= $popular[0]->title; ?></a></h5>
                </header>
                <div class="mainArticle__descBlock">
                  <p class="mainArticle__desc"><?= Yii::$app->common->getShort($popular[0]->description); ?></p>
                  <a href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>" class="mainArticle__continue">Далее</a>
                </div>
                <div class="mainArticle__social">
                  <div class="mainArticle__identity">
                    <a href="#" class="mainArticle__identityLeft">
                      <img src="<?= $popular[0]->author->image; ?>" alt="thumbnail" class="mainArticle__thumbnail">
                    </a>
                    <div class="mainArticle__identityRight">
                      <a href="#" class="mainArticle__author"><?= $popular[0]->author->username; ?> <?= $popular[0]->author->last_name; ?></a> 
                      <span class="mainArticle__date"><?= $popular[0]->getDate($timezoneoffset); ?></span>
                    </div>
                  </div>
                  <ul class="mainArticle__socialIcons">
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-comments"></i><span class="mainArticle__socialText"><?= $popular[0]->getComments()->count() ?></span></li>
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fa fa-eye"></i><span class="mainArticle__socialText"><?= (int) $popular[0]->viewed; ?></span></li>
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-up"></i><span class="mainArticle__socialText"><?= $popular[0]->like_up; ?></span></li>            
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-down"></i><span class="mainArticle__socialText"><?= $popular[0]->like_down; ?></span></li>            
                  </ul>
                </div>
              </div>
            </article>
          </div>
          <div class="col-md-6">
            <article class="mainArticle mainArticle_small-one">
              <div class="mainArticle__imgWrap">
                <a class="mainArticle__imgWrapLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"><img class="mainArticle__img" src="<?= $popular[0]->getImage(); ?>" alt="post"></a>
                <a class="mainArticle__overlay" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>">
                  <i class="fas fa-eye mainArticle__eye"></i>
                </a>
              </div>
              <div class="mainArticle__content">
                <header class="mainArticle__titles">
                  <h6 class="h6 mainArticle__titleCategory"><a class="mainArticle__titleCategoryLink" href="<?= Url::toRoute(['site/category', 'id' => $popular[0]->category->id ?? '#']) ?>"><?= $popular[0]->category->title ?? 'Категория не определена' ?></a></h6>
                  <h5 class="h5 mainArticle__titlePost"><a class="posts__titlePostLink" href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>"> <?= $popular[0]->title; ?></a></h5>
                </header>
                <div class="mainArticle__descBlock">
                  <p class="mainArticle__desc"><?= Yii::$app->common->getShort($popular[0]->description); ?></p>
                  <a href="<?= Url::toRoute(['site/view', 'id' => $popular[0]->id]); ?>" class="mainArticle__continue">Далее</a>
                </div>
                <div class="mainArticle__social">
                  <div class="mainArticle__identity">
                    <a href="#" class="mainArticle__identityLeft">
                      <img src="<?= $popular[0]->author->image; ?>" alt="thumbnail" class="mainArticle__thumbnail">
                    </a>
                    <div class="mainArticle__identityRight">
                      <a href="#" class="mainArticle__author"><?= $popular[0]->author->username; ?> <?= $popular[0]->author->last_name; ?></a> 
                      <span class="mainArticle__date"><?= $popular[0]->getDate($timezoneoffset); ?></span>
                    </div>
                  </div>
                  <ul class="mainArticle__socialIcons">
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-comments"></i><span class="mainArticle__socialText"><?= $popular[0]->getComments()->count() ?></span></li>
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fa fa-eye"></i><span class="mainArticle__socialText"><?= (int) $popular[0]->viewed; ?></span></li>
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-up"></i><span class="mainArticle__socialText"><?= $popular[0]->like_up; ?></span></li>            
                    <li class="mainArticle__socialOne"><i class="mainArticle__socialIcon fas fa-thumbs-down"></i><span class="mainArticle__socialText"><?= $popular[0]->like_down; ?></span></li>            
                  </ul>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
