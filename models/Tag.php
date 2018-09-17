<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
      return $this->hasMany(Article::className(), ['id' => 'article_id'])
        ->viaTable('article_tag', ['tag_id' => 'id']);
    }
    
    public static function getAllTags()
    {
      return Tag::find()->all();
    }
    
    public static function getTagsByTitle($tag, $pageSize = null)
    {
      if(is_null($pageSize)){
          $pageSize = Yii::$app->params['pageDefaultSize'];
      }
      $query = Tag::find()->where(['title' => $tag]);
      $count = $query->count();
      $pagination = new Pagination([
          'totalCount' => $count, 
          'pageSize' => $pageSize
      ]);

      $tags = $query->offset($pagination->offset)
      ->limit($pagination->limit)
      ->all();

      $data['tags'] = $tags;
      $data['pagination'] = $pagination;

      return $data;
    }
    
}
