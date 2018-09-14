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
use app\models\CommentForm;
use app\models\SubscribeForm;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
  
  public function actionComment($id)
  {
    $model = new CommentForm();

    if (Yii::$app->request->isPost) {
      $model->load(Yii::$app->request->post());
      if ($model->saveComment($id)) {
        //Yii::$app->getSession()->setFlash('comment', 'Your comment will be added soon');
        return $this->redirect(['site/view', 'id' => $id]);
      }
    }
  }

  public function actionEditComment($comment_id)
  {
    $model = new CommentForm();
    if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if ($model->validate() && $result = $model->saveEditedComment($comment_id)) {
        return $result;
      }
      Yii::$app->session->addFlash('error', 'Произошла ошибка при изменении комментария');
      return false;
    }
  }

  public function actionDeleteComment($comment_id)
  {
    $article_id = Comment::getArticleIdByCommentId($comment_id);
    if (!$article_id) {
      throw new NotFoundHttpException();
    }
    $model = new CommentForm();
    if (Yii::$app->request->isPost) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if ($result = $model->deleteComment($comment_id)) {
        $amount = Comment::find()->where(['article_id' => $article_id])->count();
        $result['amount'] = $amount;
        $result['declension'] = Yii::$app->common->ru_plural($amount, [
            'комментарий',
            'комментария',
            'комментариев'
        ]);
        return $result;
      }
      Yii::$app->session->addFlash('error', 'Произошла ошибка при удалении комментария');
      return false;
    } else {
      throw new NotFoundHttpException();
    }
  }
  
  public function actionLikeUp($article_id)
  {
    if(!is_numeric($article_id)){
      throw new NotFoundHttpException();
    }
    $model = Article::findOne(['id' => $article_id]);
    if (Yii::$app->request->isPost && $model) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if($model->likeUp()){
        $likes_amount = $model->likesAmount();
        $dislikes_amount = $model->dislikesAmount();
        return [
          'success' => 1, 
          'likes_amount' => $likes_amount,
          'dislikes_amount' => $dislikes_amount,
        ];
      }
      return false;
    } else {
      throw new NotFoundHttpException();
    }
  }
  
  public function actionLikeDown($article_id)
  {
    if(!is_numeric($article_id)){
      throw new NotFoundHttpException();
    }
    $model = Article::findOne(['id' => $article_id]);
    if (Yii::$app->request->isPost && $model) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if($model->likeDown()){
        $likes_amount = $model->likesAmount();
        $dislikes_amount = $model->dislikesAmount();
        return [
          'success' => 1, 
          'likes_amount' => $likes_amount,
          'dislikes_amount' => $dislikes_amount,
        ];
      }
      return false;
    } else {
      throw new NotFoundHttpException();
    }
  }

}
