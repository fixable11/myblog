<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index tagIndex">

  <h1 class="tagIndex__title"><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <ul class="tagIndex__ul">
    <li class="tagIndex__li">
      <?= Html::a('Create Tag', ['create'], ['class' => 'btn btn-success tagIndex__link']) ?>
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
