<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Article;
use yii\data\Pagination;
use app\models\Category;
use app\models\Comment;
use app\models\Likes;
use app\models\CommentForm;
use app\models\SubscribeForm;
use yii\web\NotFoundHttpException;
use app\models\Tag;
use app\models\SearchForm;

class SearchController extends Controller
{

  public function actionIndex($q)
  {
    $pageSize = Yii::$app->params['pageDefaultSize'];
    
    $searchModel = new SearchForm();
    $searchModel->keyword = $q;
    
    $data = $searchModel->search();
    
    $recent = Article::getRecent();
    $categories = Category::getAll();
    $subModel = new SubscribeForm();
    $tags = Tag::getAllTags();
    
    return $this->render('search', [
        'articles' => $data['articles'],
        'pagination' => $data['pagination'],
        'query' => $q,
        'recent' => $recent,
        'categories' => $categories,
        'subModel' => $subModel,
        'tags' => $tags,
    ]);
  }

}

 