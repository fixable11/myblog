<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ImageUpload;
use yii\web\UploadedFile;
use app\models\Category;
use app\models\Tag;
use yii\helpers\ArrayHelper;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{

  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ],
    ];
  }

  public function beforeAction($action)
  {
    
    return parent::beforeAction($action);
  }

  /**
   * Lists all Article models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new ArticleSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Article model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    return $this->render('view', [
        'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Article model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Article();
    $imageModel = new ImageUpload();
    
    if($model->load(Yii::$app->request->post())) {
      $file = UploadedFile::getInstance($model, 'image');
      if($file){
        $filename = $imageModel->uploadFile($file, $model->image);
        $model->image = $filename;
      }
      if($model->saveArticle()){
        return $this->redirect(['view', 'id' => $model->id]);
      }
    }

    return $this->render('create', [
        'model' => $model,
    ]);
  }

  /**
   * Updates an existing Article model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $imageModel = new ImageUpload();
    
    $selectedCategory = ($model->category) ? $model->category->id : '0';
    $categories = Category::getAllCategories();
    
    $selectedTags = $model->getSelectedTags();
    $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
    
    if($imageModel->fileExists($model->image)){
      $oldImage = $model->image;
    }
    
    if ($model->load(Yii::$app->request->post())) {
      $model->category_id = Yii::$app->request->post('category');
      $model->saveTags(Yii::$app->request->post('tags'));
      $this->whetherChangeImage($model, $imageModel, $oldImage);
      if($model->saveArticle()){
        return $this->redirect(['view', 'id' => $model->id]);
      }   
    }

    return $this->render('update', [
        'model' => $model,
        'selectedCategory' => $selectedCategory,
        'categories' => $categories,
        'selectedTags' => $selectedTags,
        'tags' => $tags,
    ]);
  }
  
  /**
   * Checks whether need to change current image or save previous one
   * 
   * @param type $model
   * @param type $imageModel
   * @param type $oldImage
   */
  private function whetherChangeImage($model, $imageModel, $oldImage)
  {
    $file = UploadedFile::getInstance($model, 'image');
    if(isset($file)){
      $filename = $imageModel->uploadFile($file, $model->image);
    }
    if(isset($filename)){
      $model->image = $filename;
    } else {
      $model->image = $oldImage;
    }
  }

  /**
   * Deletes an existing Article model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Article model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Article the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Article::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }

}
