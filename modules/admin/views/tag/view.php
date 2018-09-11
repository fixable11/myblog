<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Tag */

YiiAsset::register($this);

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-view tagView">

  <h1 class="tagView__title"><?= Html::encode($this->title) ?></h1>

  <ul class="tagView__ul">
    <li class="tagView__li">
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary tagView__btnUpdate']) ?>
    </li>
    <li class="tagView__li">
      <?=
      Html::a('Delete', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger tagView__btnDelete',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post',
          ],
      ])
      ?>
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
