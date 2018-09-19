<?php
/* @var $this \yii\web\View */
/* @var $article app\models\Article */
/* @var $comments app\models\Comment */
/* @var $commentForm app\models\CommentForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

YiiAsset::register($this);

$app_id = Yii::$app->params['fb_app_id'];
$redirect_uri = Yii::$app->params['fb_redirect_uri'];

$timezoneoffset = $_COOKIE['timezoneoffset'] ?? 0;

$session = Yii::$app->session;
if (!$session->isActive) {
  $session->open();
}
if (!$session->has('state')) {
  $state = Yii::$app->security->generateRandomString();
  $session->set('state', $state);
}
$state = $session->get('state');
?>
<section class="comments">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6 class="comments__amount h6">
          <span class="comments__counter"><?= count($comments) ?></span>
          <span class="comments__declension">
            <?= \Yii::$app->common->ru_plural(count($comments), ['комментарий', 'комментария', 'комментариев']) ?>
          </span>
        </h6>
      </div>
      <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
          <div class="col-lg-12">
            <div class="comments__one">
              <div class="comment">
                <div class="comment__descBlock">
                  <div class="comment__left">
                    <div class="comment__imgWrap">
                      <img class="comment__img" src="<?= $comment->user->image ?>" alt="image">
                    </div>
                  </div>
                  <div class="comment__right">
                    <div class="comment__user">
                      <div class="comment__username"><?= $comment->user->username; ?></div>
                      <div class="comment__lastName"><?= $comment->user->last_name; ?></div>
                    </div>
                    <?php if (\Yii::$app->user->can('editOwnComments', ['author_id' => $comment->user_id])): ?>
                      <div class="comment__deleteWrap">
                        <?php
                        $form = ActiveForm::begin([
                            'action' => ['article/delete-comment', 'comment_id' => $comment->id],
                            'options' => ['class' => 'comment__deleteForm contact-form', 'role' => 'form'],
                            'enableAjaxValidation' => true,
                            //'validationUrl' => '',
                            'fieldConfig' => ['options' => ['class' => 'comment__deleteFormWrap']],
                        ]);
                        ?>
                        <button type="submit" class="comment__delete">
                          <i class="fas fa-times"></i>
                        </button>
                        <?php $form->end(); ?>
                      </div>
                    <?php endif; ?>
                    <?php if (\Yii::$app->user->can('editOwnComments', ['author_id' => $comment->user_id])): ?>
                      <?php
                      $form = ActiveForm::begin([
                          'action' => ['article/edit-comment', 'comment_id' => $comment->id],
                          'options' => ['class' => 'comment__editForm contact-form', 'role' => 'form'],
                          'enableAjaxValidation' => true,
                          //'validationUrl' => '',
                          'fieldConfig' => ['options' => ['class' => 'comment__editFormWrap']],
                      ]);
                      ?>
                      <?=
                      $form->field($commentForm, 'comment')->textarea([
                          'class' => 'form-control comment__editTextarea',
                          'placeholder' => '',
                      ])->label(false);
                      ?>
                      <button type="submit" class="comment__save btn-success">Сохранить</button>
                      <?php $form->end(); ?>
                    <?php endif; ?>
                    <p class="comment__text"><?= $comment->text; ?></p>
                    <?php if (\Yii::$app->user->can('editOwnComments', ['author_id' => $comment->user_id])): ?>
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
                      <?= $comment->getDate($timezoneoffset); ?>
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
        <div class="comment__leaveComment leaveComment">
          <div class="col-lg-12">
            <h4 class="leaveComment__title h6">Оставить комментарий</h4>
          </div>
          <div class="col-lg-12">
            <?php
            $form = ActiveForm::begin([
                'action' => ['article/comment', 'id' => $article->id],
                'options' => ['class' => 'contact-form leaveComment__form', 'role' => 'form'],
            //'enableAjaxValidation' => true,
            //'validationUrl' => '',
            //'fieldConfig' => ['options' => ['class' => '']],
            ])
            ?>

            <?=
            $form->field($commentForm, 'comment', [
            ])->textarea([
                'class' => 'form-control leaveComment__textarea',
                'placeholder' => 'Содержание...',
            ])->label(false);
            ?>
            <button type="submit" class="btn send-btn leaveComment__submitBtn">Отправить</button>
          </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
    <?php else: ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="comments__loginByNative loginByNative">
            <div class="loginByNative__loginWrap">Незарегистрированный пользователь не может оставлять комментарии.
              Вам необходимо: 
              <a href="<?= Url::to(['auth/login']) ?>" class="loginByNative__loginLink">войти</a> или
              <a href="<?= Url::to(['auth/register']) ?>" class="loginByNative__registerLink">зарегистрироваться</a>.
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="comments__loginBySocials loginBySocials">
            <div class="loginBySocials__title">Войти через:</div>
            <ul class="loginBySocials__ul">
              <li class="loginBySocials__li">
                <a href="https://www.facebook.com/v3.1/dialog/oauth?client_id=<?= $app_id; ?>&redirect_uri=<?= $redirect_uri; ?>&state=<?= $state; ?>" class="loginBySocials__fb">
                  <i class="fab fa-facebook loginBySocials__fbIcon"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>