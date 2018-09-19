<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//AppAsset::register($this);
PublicAsset::register($this);

if(isset(Yii::$app->user->identity->last_name)){
  $last_name = ' ' . Yii::$app->user->identity->last_name;
} else{
  $last_name = '';
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  </head>
  <body>
    <?php $this->beginBody() ?>
    <div class="wrapper">
      <header class="mainHeader">
        <div class="mainHeaderInner">
          <div class="container">
            <div class="row">
              <nav class="mainHeader__nav mainHeaderNav">
                <a class="mainHeaderNav__logoLink" href="<?= Url::home(); ?>"><img src="<?= Yii::getAlias('@web'); ?>/images/logo.svg" alt="logo"></a>
                <div class="mainHeaderNav__barsWrap">
                  <i class="fas fa-bars mainHeaderNav__barsIcon"></i>
                </div>
                <div class="mainHeaderNav__ulWrap">
                  <ul class="mainHeaderNav__ul">
                    <li class="mainHeaderNav__li"><a class="mainHeaderNav__a" href="<?= Url::home(); ?>">Главная</a></li>
                    <?php if (Yii::$app->user->isGuest): ?>
                      <li class="mainHeaderNav__li"><a class="mainHeaderNav__a" href="<?= Url::toRoute(['auth/login']) ?>">Логин</a></li>
                      <li class="mainHeaderNav__li"><a class="mainHeaderNav__a" href="<?= Url::toRoute(['auth/register']) ?>">Регистрация</a></li>
                    <?php else: ?>
                      <li class="mainHeaderNav__li">
                        <?= Html::beginForm(['/auth/logout'], 'post') ?>
                          <?= Html::submitButton('Выход (' . Yii::$app->user->identity->username . $last_name . ')', ['class' => 'mainHeaderNav__a']);
                          ?>
                        <?= Html::endForm() ?>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </nav>
              <div class="mainHeader__search mainSearch">
                <form method="GET" action="/search" class="mainSearch__form">
                  <button class="mainSearch__submit">
                    <i class="fas fa-search mainSearch__icon"></i>
                  </button>  
                  <input type="text" class="mainSearch__searchField" name="q" placeholder="Что ищем?">  
                </form>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="content">
        <?= $content; ?>
      </div>

      <footer class="mainFooter">
        <div class="mainFooterWrap">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="mainFooter__copy">
                  &copy; 2018 Treasure Blog.
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>

    </div><!-- /.wrapper -->
    <script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
          return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.1&appId=252956782145525&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
