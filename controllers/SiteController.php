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

class SiteController extends Controller
{

  const ARTICLES_PER_PAGE = 4;

  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['logout'],
            'rules' => [
                [
                    'actions' => ['logout'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
        'error' => [
            'class' => 'yii\web\ErrorAction',
        ],
        'captcha' => [
            'class' => 'yii\captcha\CaptchaAction',
            'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
        ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    $data = Article::getAll(self::ARTICLES_PER_PAGE, Yii::$app->params['popularLimit']);
    $popular = Article::getPopular(Yii::$app->params['popularLimit']);
    $recent = Article::getRecent();
    $categories = Category::getAll();
    $tags = Tag::getAllTags();

    $subModel = new SubscribeForm();

    return $this->render('index', [
        'articles' => $data['articles'],
        'pagination' => $data['pagination'],
        'popular' => $popular,
        'recent' => $recent,
        'categories' => $categories,
        'subModel' => $subModel,
        'tags' => $tags,
    ]);
  }

  /**
   * Displays contact page.
   *
   * @return Response|string
   */
  public function actionContact()
  {
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
      Yii::$app->session->setFlash('contactFormSubmitted');

      return $this->refresh();
    }
    return $this->render('contact', [
        'model' => $model,
    ]);
  }

  /**
   * Displays category page. Searching by category
   *
   * @param int $id Category id
   * @param int $pageSize Articles per page
   * @return string The rendering result
   */
  public function actionCategory($id, $pageSize = null)
  {
    $data = Category::getArticlesByCategory($id, $pageSize);
    $recent = Article::getRecent();
    $categories = Category::getAll();
    $subModel = new SubscribeForm();
    $tags = Tag::getAllTags();

    return $this->render('category', [
        'articles' => $data['articles'],
        'pagination' => $data['pagination'],
        'categoryName' => $data['categoryName'],
        'recent' => $recent,
        'categories' => $categories,
        'subModel' => $subModel,
        'tags' => $tags,
    ]);
  }
  
  /**
   * Displays tag page. Searching by tag
   * 
   * @param int $tag Tag title
   * @param int $pageSize Articles per page
   * @return string The rendering result
   */
  public function actionTags($tag, $pageSize = null)
  {
    if (is_null($pageSize)) {
      $pageSize = Yii::$app->params['pageDefaultSize'];
    }
    
    $data = Tag::getArticlesByTagTitle($tag);
    $recent = Article::getRecent();
    $categories = Category::getAll();
    $subModel = new SubscribeForm();
    $tags = Tag::getAllTags();
    
    return $this->render('tags', [
        'articles' => $data['articles'],
        'pagination' => $data['pagination'],
        'tagName' => $data['tag_name'],
        'recent' => $recent,
        'categories' => $categories,
        'subModel' => $subModel,
        'tags' => $tags,
    ]);
  }

  /**
   * Displays article page
   * 
   * @param type $id Article id
   * @return string The rendering result
   */
  public function actionView($id)
  {
    $article = Article::findOne($id);
    $popular = Article::getPopular(Yii::$app->params['popularLimit']);
    $recent = Article::getRecent();
    $categories = Category::getAll();
    $comments = $article->getArticleComments(); //return comments with status 1
    $commentForm = new CommentForm();
    $subModel = new SubscribeForm();
    $tags = Tag::getAllTags();

    $article->viewedCounter();

    return $this->render('single', [
        'article' => $article,
        'popular' => $popular,
        'recent' => $recent,
        'categories' => $categories,
        'comments' => $comments,
        'commentForm' => $commentForm,
        'subModel' => $subModel,
        'tags' => $tags,
    ]);
  }

}
