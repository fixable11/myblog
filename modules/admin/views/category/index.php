<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoryleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index categoryIndex">

  <h1 class="categoryIndex__title"><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <ul class="categoryIndex__ul">
    <li class="categoryIndex__li">
      <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success categoryIndex__link']) ?>
    </li>
  </ul>

  <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'id',
          'title',
          ['class' => 'yii\grid\ActionColumn'],
      ],
  ]); ?>
</div>
