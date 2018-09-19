<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Comment */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index comments">

  <h1 class="comments__title"><?= Html::encode($this->title) ?></h1>
  <?php Pjax::begin(); ?>
  <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
        'id',
        'text',
        [
            'label' => 'Allow',
            'format' => 'raw',
            'value' => function($data)
            {
              if($data->status){
                $output = Html::beginForm(['comments/disallow', 'id' => $data->id], 'post', ['class' => 'comments__disallowForm']);
                $output .= Html::submitButton('Disallow', ['class' => 'btn btn-warning comments__disallowSubmit']);
                $output .= Html::endForm();
                return $output;
              } else {
                $output = Html::beginForm(['comments/allow', 'id' => $data->id], 'post', ['class' => 'comments__allowForm']);
                $output .= Html::submitButton('Allow', ['class' => 'btn btn-success comments__allowSubmit']);
                $output .= Html::endForm();
                return $output;
              }
             
            }
        ],
        [
            'label' => 'Delete',
            'format' => 'raw',
            'value' => function($data)
            {
                $output = Html::beginForm(['comments/delete', 'id' => $data->id], 'post', ['class' => 'comments__deleteForm']);
                $output .= Html::submitButton('Delete', ['class' => 'btn btn-danger comments__deleteSubmit']);
                $output .= Html::endForm();
                return $output;       
            }
        ],
        'user_id',
        'article_id',
        [
            'label' => 'Article Link',
            'format' => 'raw',
            'value' => function($data)
            {
              return Html::a(
              'Перейти', Url::to(['/site/view', 'id' => $data->article_id]), [
                  'target' => '_blank'
              ]
              );
            }
        ],
        'status',
        'date',
      ],
  ]); ?>
  <?php Pjax::end(); ?>

  <?php if(empty($comments)):?>
  <div class="comments__tableWrap">
      <table class="table comments__table">
          <thead>
              <tr>
                  <td>#</td>
                  <td>Author</td>
                  <td>Text</td>
                  <td>Action</td>
              </tr>
          </thead>

          <tbody>
              <?php foreach($comments as $comment):?>
                  <tr>
                      <td><?= $comment->id; ?></td>
                      <td><?= $comment->user->username; ?></td>
                      <td><?= $comment->text; ?></td>
                      <td>
                          <?php if($comment->isAllowed()):?>
                              <a class="btn btn-warning" href="<?= Url::toRoute(['comment/disallow', 'id'=>$comment->id]);?>">Disallow</a>
                          <?php else:?>
                              <a class="btn btn-success" href="<?= Url::toRoute(['comment/allow', 'id'=>$comment->id]);?>">Allow</a>
                          <?php endif?>
                          <a class="btn btn-danger" href="<?= Url::toRoute(['comment/delete', 'id' => $comment->id]); ?>">Delete</a>
                      </td>
                  </tr>
              <?php endforeach;?>
          </tbody>
      </table>
  </div>

  <?php endif;?>
</div>




<!--<button type="submit" class="comment__delete">
  <i class="fas fa-times"></i>
</button>-->
