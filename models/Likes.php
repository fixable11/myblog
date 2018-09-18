<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property int $liked
 * @property int $disliked
 *
 * @property Article $article
 * @property User $user
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'user_id', 'liked', 'disliked'], 'integer'],
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
            'article_id' => 'Article ID',
            'user_id' => 'User ID',
            'liked' => 'Liked',
            'disliked' => 'Disliked',
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
     * Checks whether user liked specific article
     * 
     * @param type $article_id Article id
     * @return boolean
     */
    public static function whetherUserLiked($article_id)
    {
      $model = Likes::findOne(['article_id' => $article_id, 'user_id' => Yii::$app->user->id]);
      if($model){
        return $model->liked;
      }
      return false;
    }
    
    /**
     * Checks whether user liked disliked article
     * 
     * @param type $article_id Article id
     * @return boolean
     */
    public static function whetherUserDisliked($article_id)
    {
      $model = Likes::findOne(['article_id' => $article_id, 'user_id' => Yii::$app->user->id]);
      if($model){
        return $model->disliked;
      }
      return false;
    }
    
    /**
     * Sets 'liked' column for specific user 
     * 
     * @return boolean Whether saved has been successful
     */
    public function doLike()
    {
      $model = new Likes(); 
      $model->article_id = $this->id;
      $model->user_id = Yii::$app->user->id;
      $model->liked = 1;
      $model->disliked = 0;
      return $model->save();
    }
    
    /**
     * Sets 'disliked' column for specific user 
     * 
     * @return boolean Whether saved has been successful
     */
    public function doDislike()
    {
      $model = new Likes(); 
      $model->article_id = $this->id;
      $model->user_id = Yii::$app->user->id;
      $model->liked = 0;
      $model->disliked = 1;
      return $model->save();
    }
}
