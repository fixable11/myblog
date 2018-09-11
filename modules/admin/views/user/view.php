<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view userView">

  <h1 class="userView__title">#<?= Html::encode($this->title) ?> (<?= Html::encode($model->username) ?><?= Html::encode($model->last_name) ?>)</h1>

  <ul class="userView__ul">
    <li class="userView__li">
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary userView__link']) ?>
    </li>
    <li class="userView__li">
      <?= Html::a('Delete', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger userView__link',
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
      'username',
      'last_name',
      'email:ntext',
      'photo', 
      'photo_rec:image',
      'fb_uid',
      [
        'attribute' => 'roles',
        'value' => function($user){
          if($user->getRoles()){
            return implode(', ', $user->getRoles());
          }
          return null;
        }
      ]
    ],
  ]) ?>

</div>
