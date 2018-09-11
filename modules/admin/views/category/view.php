<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

YiiAsset::register($this);

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view categoryView">

  <h1 class="categoryView__title"><?= Html::encode($this->title) ?></h1>

  <ul class="categoryView__ul">
    <li class="categoryView__li">
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary categoryView__link']) ?>
    </li>
    <li class="categoryView__li">
      <?= Html::a('Delete', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger categoryView__link',
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
      ],
  ]) ?>

</div>
