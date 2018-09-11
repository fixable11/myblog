<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index userIndex">

  <h1 class="user__title"><?= Html::encode($this->title) ?></h1>
  <?php Pjax::begin(); ?>
  <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
  <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'id',
          'username',
          'last_name',
          'email:ntext',
          [
            'attribute' => 'relatedRoles.item_name',
            'label' => 'Roles',
            'value' => function($user){
              $arr = ArrayHelper::getColumn($user->relatedRoles, 'item_name');
              if($arr){
                return implode(', ', $arr);
              }
              return null;
            }
          ],
          [
            'format' => 'html',
            'label' => 'Image',
            'value' => function($model){
              return Html::img($model->getImage(), ['width' => 50]);
            }
          ],
          [
            'class' => 'yii\grid\ActionColumn',
          ],
      ],
  ]); ?>
  <?php Pjax::end(); ?>
</div>
