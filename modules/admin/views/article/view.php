<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

YiiAsset::register($this);

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view articleView">

  <h1 class="articleView__title"><?= Html::encode($this->title) ?></h1>

  <ul class="articleView__ul articleView__links">
    <li class="articleView__li">
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </li>
    <li class="articleView__li">
      <?= Html::a('Delete', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger articleView__btnDelete',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post',
          ],
      ]) ?>
    </li>
  </ul>

  <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
          'id',
          'title',
          'description:ntext',
          'content:html',
          [
            'format' => 'ntext',
            'attribute' => 'date',
            'value' => function($model){
              $timezoneoffset = $_COOKIE['timezoneoffset'] ?? 0;
              return $model->getDate($timezoneoffset);
            }
          ],
          'image',
          [
            'format' => 'html',
            'attribute' => 'image',
            'value' => function($model){
              return Html::img($model->getImage(), ['alt' => 'img', 'width' => 200]);
            }
          ],
          'viewed',
          'user_id',
          'status',
          'category_id',
          [
            'attribute' => 'tags',
            'value' => function($model){
              if($model->tags){
                return implode(', ', ArrayHelper::getColumn($model->tags, 'title'));
              }
              return null;
            }
          ]
      ],
  ]) ?>

</div>
