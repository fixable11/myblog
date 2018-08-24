<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user common\models\User */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset-password', 'token' => $user->password_reset_token]);
?>

<div class="passwordResetMail">
  <p class="passwordResetMail__desc">Привет <span style="font-weight: bold;" class="passwordResetMail__username"><?= Html::encode($user->username) ?></span>,</p>
  <p class="passwordResetMail__desc">Перейдите по ссылке внизу для восстановления пароля:</p>
  <p class="passwordResetMail__desc"><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>