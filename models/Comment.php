<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $article_id
 * @property int $status
 *
 * @property Article $article
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{

  const STATUS_ALLOW = 1;
  const STATUS_DISALLOW = 0;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'comment';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['user_id', 'article_id', 'status'], 'integer'],
        [['text'], 'string', 'max' => 255],
        [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
        'id' => 'ID',
        'text' => 'Text',
        'user_id' => 'User ID',
        'article_id' => 'Article ID',
        'status' => 'Status',
    ];
  }

  /**
   * Article table relation
   * 
   * @return \yii\db\ActiveQuery
   */
  public function getArticle()
  {
    return $this->hasOne(Article::className(), ['id' => 'article_id']);
  }

  /**
   * User table relation
   * 
   * @return \yii\db\ActiveQuery
   */
  public function getUser()
  {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
  }
  
  /**
   * Returns data in formatted view
   * 
   * @param int $offset Timezone offset
   * @return string
   */
  public function getDate($offset = 0)
  {
    $timestamp = strtotime($this->date);
    $date = $timestamp + $offset * 60 * 60;
    return Yii::$app->formatter->asDate($date, 'dd.MM.yyyy в HH:mm:ss');
  }
  
  /**
   * Whether status of comment == 1
   * 
   * @return int 1|0
   */
  public function isAllowed()
  {
    return $this->status;
  }

  /**
   * Sets allow status to comment
   * 
   * @return boolean
   */
  public function allow()
  {
    $this->status = self::STATUS_ALLOW;
    return $this->save(false);
  }

   /**
   * Sets disallow status to comment
   * 
   * @return boolean
   */
  public function disallow()
  {
    $this->status = self::STATUS_DISALLOW;
    return $this->save(false);
  }
  
  /**
   * Returns article id by comment id
   * 
   * @param type $comment_id Comment id
   * @return int Article id
   */
  public static function getArticleIdByCommentId($comment_id)
  {
    $comment = Comment::find()->where(['id' => $comment_id])->one();
    if($comment){
      return $comment->article_id;
    }
    return null;
  }
  
  /**
   * Returns comment's UTC timestamp
   * 
   * @return string UTC timestamp
   */
  public function getTimestamp()
  {
    $timestamp = strtotime($this->date);
    return $timestamp;
  }

}
