<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $imageFolder app\models\UploadImage */
/* @var $selectedCategory app\models\Category */
/* @var $categories app\models\Category */
/* @var $selectedTags app\models\Tag */
/* @var $tags app\models\Tag */


$this->title = 'Update Article: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update articleUpdate">

  <h1 class="articleUpdate__title"><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
      'model' => $model,
      'selectedCategory' => $selectedCategory,
      'categories' => $categories,
      'selectedTags' => $selectedTags,
      'tags' => $tags,
  ]) ?>

</div>
