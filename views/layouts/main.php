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

//AppAsset::register($this);
PublicAsset::register($this);
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
	<header class="mainHeader">
		<div class="mainHeaderInner">
			<div class="container">
				<div class="row">
					<nav class="mainHeader__nav mainHeaderNav">
						<a class="mainHeaderNav__logoLink" href="<?= Url::home(); ?>"><img src="/images/logo.jpg" alt="logo"></a>
						<ul class="mainHeaderNav__ul">
							<li class="mainHeaderNav__li"><a class="mainHeaderNav__a" href="<?= Url::home(); ?>">Главная</a></li>
							<?php if (Yii::$app->user->isGuest): ?>
								<li class="mainHeaderNav__li"><a class="mainHeaderNav__a" href="<?= Url::toRoute(['auth/login']) ?>">Логин</a></li>
								<li class="mainHeaderNav__li"><a class="mainHeaderNav__a" href="<?= Url::toRoute(['auth/register']) ?>">Регистрация</a></li>
							<?php else: ?>
								<?= Html::beginForm(['/auth/logout'], 'post') ?>
								<li class="mainHeaderNav__li">
									<?= Html::submitButton('Выход (' . Yii::$app->user->identity->username . ')', ['class' => 'mainHeaderNav__a']);
									?>
								</li>
								<?= Html::endForm() ?>
							<?php endif; ?>
						</ul>
					</nav>
				</div>
			</div>
		</header>

		<?= $content; ?>

		<footer class="footer-widget-section">
			<div class="footer-copy">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="text-center">&copy; 2018 
								<a href="#">Treasure Blog.</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<?php $this->endBody() ?>
	</body>
	</html>
	<?php $this->endPage() ?>
