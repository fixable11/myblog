<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update User: ' . $model->id . '(' . $model->username . ' ' . $model->last_name . ')';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userUpdate user-update">
  <h1 class="userUpdate__title"><?= Html::encode($this->title) ?></h1>
  <div class="userUpdate__imgWrap">
    <?php if(isset($model->photo_rec)): ?>
      <img src="<?=$model->photo_rec ?>" alt="img" class="userUpdate__img">
    <?php endif; ?>
  </div>

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
