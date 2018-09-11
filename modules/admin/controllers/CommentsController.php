<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Comment;
use app\models\CommentsSearch;


/**
 * CommentsController
 */
class CommentsController extends Controller
{
    /**
     * Shows all comments
     * @return mixed yii\web\View
     */
    public function actionIndex()
    {
        $comments = Comment::find()->orderBy('id desc')->all();
        
        $searchModel = new CommentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'comments' => $comments,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);
        if($comment->delete())
        {
            return $this->redirect(['comment/index']);
        }
    }
    
    public function actionAllow($id)
    {
        $comment = Comment::findOne($id);
        if($comment->allow()){
            return $this->redirect(['index']);
        }
    }
    
    public function actionDisallow($id)
    {
        $comment = Comment::findOne($id);
        if($comment->disallow()){
            return $this->redirect(['index']);
        }
    }
    
    
}
