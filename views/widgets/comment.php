<?php
/* @var $this \yii\web\View */
/* @var $article app\models\Article */
/* @var $comments app\models\Article */
/* @var $commentForm app\models\CommentForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<section class="comments">
  <div class="container">
    <div class="row">
      <?php if (!empty($comments)): ?>
        <div class="col-lg-12">
          <h4 class="comments__amount h4">3 comments</h4>
        </div>
        <?php foreach ($comments as $comment): ?>
          <div class="col-lg-12">
            <div class="comments__one">
              <div class="comment">
                <div class="comment__descBlock">
                  <div class="comment__left">
                    <div class="comment__imgWrap">
                      <img class="comment__img" src="<?php if ($comment->user->image) echo $comment->user->image; else echo Yii::getAlias('@web') . '/images/default-user.png'; ?>" alt="image">
                    </div>
                  </div>
                  <div class="comment__right">
                    <div class="comment__user">
                      <div class="comment__username"><?= $comment->user->username; ?></div>
                      <div class="comment__lastName"><?= $comment->user->last_name; ?></div>
                    </div>
                    <?php if (\Yii::$app->user->can('editComments', ['author_id' => $comment->user_id])): ?>
                      <?php $form = ActiveForm::begin([
                          'action' => ['site/edit-comment', 'id' => $article->id, 'comment_id' => $comment->id],
                          'options' => ['class' => 'comment__editForm contact-form', 'role' => 'form'],
                          'enableAjaxValidation' => true,
                          //'validationUrl' => '',
                          'fieldConfig' => ['options' => ['class' => 'comment__editFormWrap']],
                      ]); ?>
                      <?= $form->field($commentForm, 'comment')->textarea([
                          'class' => 'form-control comment__editTextarea',
                          'placeholder' => '',
                      ])->label(false); ?>
                      <button type="submit" class="comment__save btn-success">Сохранить</button>
                      <?php $form->end(); ?>
                    <?php endif; ?>
                    <p class="comment__text"><?= $comment->text; ?></p>
                    <?php if (\Yii::$app->user->can('editComments', ['author_id' => $comment->user_id])): ?>
                      <div class="comment__event">
                        <div class="alert alert-danger fade show comment__danger" role="alert">
                          <p class="comments__dangerText">Извините, произошла ошибка при редактировании комментария!</p>
                        </div>
                        <div class="alert alert-success fade show comment__success" role="alert">
                          <p class="comments__dangerText">Ваше комментарий успешно отредактирован!</p>
                        </div>
                      </div>
                      <button class="comment__edit btn-info">Редактировать</button>
                      <button  class="comment__cancel btn-danger">Отменить</button>
                    <?php endif; ?>
                    <div class="comment__date">
                      <?= $comment->getDate(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <?php if (!Yii::$app->user->isGuest): ?>
      <div class="row">
      
      <?php var_dump(Yii::$app->user->isGuest); ?>
      <div class="leave-comment"><!--leave comment-->
        <h4>Leave a reply</h4>
          <?php if (Yii::$app->session->getFlash('comment')): ?>
          <div class="alert alert-success" role='alert'>
          <?= Yii::$app->session->getFlash('comment') ?>
          </div>
        <?php endif; ?>
        <?php
        $form = ActiveForm::begin([
            'action' => ['site/comment', 'id' => $article->id],
            'options' => ['class' => 'form-horizontal contact-form', 'role' => 'form'],
        ])
        ?>
        <div class="form-group">
          <div class="col-md-12">
            <?=
            $form->field($commentForm, 'comment')->textarea([
                'class' => 'form-control',
                'placeholder' => 'Write message!'
            ])->label(false);
            ?>
          </div>
        </div>
        <button type="submit" class="btn send-btn">Post Comment</button>
      <?php ActiveForm::end(); ?>
      </div><!--end leave comment-->
      </div>
    <?php else: ?>
      <div class="row">
        <div class="col-lg-12">
          <a href="<?= Url::to(['auth/oauth-vk'], true); ?>">Войти</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>