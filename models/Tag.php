<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $title
 *
 * @property ArticleTag[] $articleTags
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
      return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      return [
          [['title'], 'string', 'max' => 255],
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
      return [
          'id' => 'ID',
          'title' => 'Title',
      ];
    }

    /**
     * Article table relation via article_tag table
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
      return $this->hasMany(Article::className(), ['id' => 'article_id'])
        ->viaTable('article_tag', ['tag_id' => 'id']);
    }
    
    /**
     * Gets all existing tags
     * 
     * @return type
     */
    public static function getAllTags()
    {
      return Tag::find()->all();
    }
    
    /**
     * Gets tag id by given title
     * 
     * @param type $title
     * @return type
     */
    public static function getTagIdByTitle($title)
    {
      return Tag::find()->where(['title' => $title])->one()->id;
    }
   
    /**
     * Returns all found articles by given tag name
     * 
     * @param type $tag Tag title
     * @param type $pageSize Amount of articles per page
     * @return array Array contain: articles, pagination and tag name
     */
    public static function getArticlesByTagTitle($tag, $pageSize = null)
    {
      if(is_null($pageSize)){
          $pageSize = Yii::$app->params['pageDefaultSize'];
      }
      $tag_id = self::getTagIdByTitle($tag);
      $query = Tag::findOne($tag_id)->getArticles();
      $count = $query->count();
      $pagination = new Pagination([
          'totalCount' => $count, 
          'pageSize' => $pageSize
      ]);

      $articles = $query->offset($pagination->offset)
      ->limit($pagination->limit)
      ->all();

      $data['articles'] = $articles;
      $data['pagination'] = $pagination;
      $data['tag_name'] = $tag;

      return $data;
    }
    
}
