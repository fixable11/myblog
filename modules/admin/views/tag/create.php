<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tag */

$this->title = 'Create Tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create tagCreate">

  <h1 class="tagCreate__title"><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
      'model' => $model,
  ]) ?>

</div>
