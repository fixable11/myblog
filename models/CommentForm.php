<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CommentForm extends Model
{

  public $comment;
  
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['comment'], 'required'],
        [['comment'], 'string', 'length' => [3, 250]],
    ];
  }
  
  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий',
        ];
    }

  /**
   * Saves comment
   * 
   * @param type $article_id Article id
   * @return boolean Whether the save successful
   */
  public function saveComment($article_id)
  {
    $comment = new Comment();
    $comment->text = $this->comment;
    $comment->user_id = Yii::$app->user->id;
    $comment->article_id = $article_id;
    $comment->status = 1;
    $comment->date = date('Y-m-d');
    return $comment->save();
  }
  
  /**
   * Saves comment that has been edited
   * 
   * @param type $comment_id Comment id
   * @return boolean | string Whether the save successful
   */
  public function saveEditedComment($comment_id)
  {
    $comment = Comment::findOne(['id' => $comment_id, 'user_id' => Yii::$app->user->id]);
    if($comment === null) {
      return false;
    }
    $comment->text = $this->comment;
    //$comment->user_id = Yii::$app->user->id;
    //$comment->article_id = $article_id;
    //$comment->status = 1;
    $comment->date = date('Y-m-d');
    if($comment->save()){
      return $comment->text;
    }
    return false;
  }
  
  /**
   * Deletes comment by its id
   * 
   * @param type $comment_id Comment id
   * @return boolean | array Whether the delete was successful
   */
  public function deleteComment($comment_id)
  {
    $comment = Comment::findOne(['id' => $comment_id, 'user_id' => Yii::$app->user->id]);
    if($comment === null) {
      return false;
    }

    if($comment->delete()){
      return ['success' => 1];
    }
    return false;
  }

}
