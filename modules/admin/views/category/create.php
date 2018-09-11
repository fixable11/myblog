<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create categoryCreate">
  <h1 class="categoryCreate__title"><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
      'model' => $model,
  ]) ?>

</div>
