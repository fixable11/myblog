<?php
/* @var $this yii\web\View */

use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\widgets\Sidebar;

?>


<section class="mainArticles">
	<div class="row">
		<div class="col-lg-6">
			<div class="mainArticles__article mainArticles__bigOne mainArticlesBigOne">
				<div class="mainArticlesBigOne__top">
					<div class="mainArticlesBigOne__imgWrap">
						<img src="/images/test.png">
					</div>
				</div>
				<div class="mainArticlesBigOne__bot">  
					<div class="mainArticlesBigOne__textWrap">
						<h2 class="h2 mainArticlesBigOne__title">Lorem ipsum dolor sit amet.</h2>
						<p class="mainArticlesBigOne__p">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo animi ab dolorem deleniti, incidunt, recusandae tenetur eius aut similique delectus nisi labore odit temporibus reprehenderit eum iure natus voluptatem commodi? Quam ea, placeat quia et dignissimos laboriosam unde earum repudiandae?</p>
						<div class="articleSocial_b">
							<div class="articleSocial_b__one">
								<div class="articleSocial_b__icon articleSocial_b__icon_commentary"><i class="fas fa-comments"></i></div>
								<div class="articleSocial_b__text">Комментарии (19)</div>
							</div>
							<div class="articleSocial_b__one">
								<div class="articleSocial_b__icon articleSocial_b__icon_views"><i class="far fa-eye"></i></div>
								<div class="articleSocial_b__text">222,333</div>
							</div>
							<div class="articleSocial_b__one">
								<div class="articleSocial_b__icon articleSocial_b__icon_rightArrow"><i class="fas fa-arrow-circle-right"></i></div>
								<div class="articleSocial_b__text">Далее</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="row">
				<div class="col-lg-6">
					<div class="mainArticles__article mainArticles__bigOne mainArticlesSmallOne">
						<div class="mainArticlesSmallOne__top">
							<div class="mainArticlesSmallOne__imgWrap">
								<img src="/images/test.png">
							</div>
						</div>
						<div class="mainArticlesSmallOne__bot">  
							<div class="mainArticlesSmallOne__textWrap">
								<h2 class="h2 mainArticlesSmallOne__title">Lorem ipsum dolor sit amet.</h2>
								<div class="articleSocial_s">
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_commentary"><i class="fas fa-comments"></i></div>
										<div class="articleSocial_s__text">Комментарии (19)</div>
									</div>
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_views"><i class="far fa-eye"></i></div>
										<div class="articleSocial_s__text">222,333</div>
									</div>
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_rightArrow"><i class="fas fa-arrow-circle-right"></i></div>
										<div class="articleSocial_s__text">Далле</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mainArticles__article mainArticles__bigOne mainArticlesSmallOne">
						<div class="mainArticlesSmallOne__top">
							<div class="mainArticlesSmallOne__imgWrap">
								<img src="/images/test.png">
							</div>
						</div>
						<div class="mainArticlesSmallOne__bot">  
							<div class="mainArticlesSmallOne__textWrap">
								<h2 class="h2 mainArticlesSmallOne__title">Lorem ipsum dolor sit amet.</h2>
								<div class="articleSocial_s">
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_commentary"><i class="fas fa-comments"></i></div>
										<div class="articleSocial_s__text">Комментарии (19)</div>
									</div>
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_views"><i class="far fa-eye"></i></div>
										<div class="articleSocial_s__text">222,333</div>
									</div>
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_rightArrow"><i class="fas fa-arrow-circle-right"></i></div>
										<div class="articleSocial_s__text">Далле</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mainArticles__article mainArticles__bigOne mainArticlesSmallOne">
						<div class="mainArticlesSmallOne__top">
							<div class="mainArticlesSmallOne__imgWrap">
								<img src="/images/test.png">
							</div>
						</div>
						<div class="mainArticlesSmallOne__bot">  
							<div class="mainArticlesSmallOne__textWrap">
								<h2 class="h2 mainArticlesSmallOne__title">Lorem ipsum dolor sit amet.</h2>
								<div class="articleSocial_s">
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_commentary"><i class="fas fa-comments"></i></div>
										<div class="articleSocial_s__text">Комментарии (19)</div>
									</div>
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_views"><i class="far fa-eye"></i></div>
										<div class="articleSocial_s__text">222,333</div>
									</div>
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_rightArrow"><i class="fas fa-arrow-circle-right"></i></div>
										<div class="articleSocial_s__text">Далле</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mainArticles__article mainArticles__bigOne mainArticlesSmallOne">
						<div class="mainArticlesSmallOne__top">
							<div class="mainArticlesSmallOne__imgWrap">
								<img src="/images/test.png">
							</div>
						</div>
						<div class="mainArticlesSmallOne__bot">  
							<div class="mainArticlesSmallOne__textWrap">
								<h2 class="h2 mainArticlesSmallOne__title">Lorem ipsum dolor sit amet.</h2>
								<div class="articleSocial_s">
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_commentary"><i class="fas fa-comments"></i></div>
										<div class="articleSocial_s__text">Комментарии (19)</div>
									</div>
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_views"><i class="far fa-eye"></i></div>
										<div class="articleSocial_s__text">222,333</div>
									</div>
									<div class="articleSocial_s__one">
										<div class="articleSocial_s__icon articleSocial_s__icon_rightArrow"><i class="fas fa-arrow-circle-right"></i></div>
										<div class="articleSocial_s__text">Далле</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
