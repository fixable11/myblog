<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="article-index articleIndex">

  <h1 class="articleIndex__title"><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <div class="articleIndex__createLinkWrap">
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success articleIndex__createLink']) ?>
  </div>

  <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'id',
          'title',
          [
            'format' => 'ntext',
            'attribute' => 'description',
            'contentOptions' => ['class' => 'articleIndex__descriptionTd'],
          ],
          [
            'format' => 'html',
            'attribute' => 'content',
            'contentOptions' => ['class' => 'articleIndex__contentTd'],
          ],
          [
            'format' => 'ntext',
            'attribute' => 'date',
            'label' => 'Date(UTC)',
          ],
          [
              'format' => 'html',
              'label' => 'Image',
              'value' => function($model){
                  return Html::img($model->getImage(), ['width' => 200]);
              }
          ],
          //'image',
          //'viewed',
          //'user_id',
          //'status',
          //'category_id',
          ['class' => 'yii\grid\ActionColumn'],
      ],
  ]); ?>
</section>
