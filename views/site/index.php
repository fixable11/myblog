<?php
/* @var $this yii\web\View */

use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\widgets\Sidebar;

$this->title = 'Treasure main page';
?>
<section class="mainContent">
  <div class="container">
    <div class="row">
      <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="col-lg-12">
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p class="mainContent__successText"><?= Yii::$app->session->getFlash('success'); ?></p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      <?php endif; ?>
      <div class="col-lg-12">
        <?= $this->render('@app/views/particles/mainArticles'); ?>  
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <?= $this->render('@app/views/particles/posts', ['articles' => $articles]); ?>
        <ul class="pagination">
          <?php
          echo LinkPager::widget([
              'pagination' => $pagination,
              'disabledPageCssClass' => '',
          ]);
          ?>
        </ul>
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