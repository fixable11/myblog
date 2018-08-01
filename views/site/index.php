<?php

/* @var $this yii\web\View */

use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\widgets\Sidebar;

$this->title = 'My Yii Application';
?>
<div class="main-content">
    <div class="container">
        <div class="row">
          <div class="col-md-8">
            <?php foreach ($articles as $article): ?>
                <article class="post">
                  <div class="post-thumb">
                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><img src="<?= $article->getImage();?>" alt=""></a>

                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="post-thumb-overlay text-center">
                      <div class="text-uppercase text-center">View Post</div>
                    </a>
                  </div>
                  <div class="post-content">
                    <header class="entry-header text-center text-uppercase">
                      <h6><a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"><?= $article->category->title ?? 'Category is not defined' ?></a></h6>

                      <h1 class="entry-title"><a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"> <?= $article->title;?></a></h1>


                    </header>
                    <div class="entry-content">
                      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                        tevidulabore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et
                        justo duo dolores rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem
                        ipsum dolor sit am Lorem ipsum dolor sitconsetetur sadipscing elitr, sed diam nonumy
                        eirmod tempor invidunt ut labore et dolore maliquyam erat, sed diam voluptua.
                      </p>

                      <div class="btn-continue-reading text-center text-uppercase">
                        <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="more-link">Continue Reading</a>
                      </div>
                    </div>
                    <div class="social-share">
                      <span class="social-share-title pull-left text-capitalize">By <a href="#">Rubel</a> <?= $article->getDate(); ?> </span>
                      <ul class="text-center pull-right">
                        <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li> <?= (int) $article->viewed; ?>
                      </ul>
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
            </div>
            <div class="col-md-4" data-sticky_column>
                <?= Sidebar::widget([
                    'popular' => $popular,
                    'recent' => $recent,
                    'categories' => $categories,
                ]); ?>
            </div>
        </div>
    </div>
</div>