<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
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
    
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }
    
    public static function getAllCategories()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'title');
    }
    
    public function getArticlesCount()
    {
        return $this->getArticles()->count();
    }
    
    public static function getAll()
    {
        return Category::find()->all();
    }
    
    public static function getCategoryName($id)
    {
      if(!intval($id)){
        throw new \yii\web\NotFoundHttpException();
      }
      return Category::find()->where(['id' => $id])->one()->title;

    }
    
    public static function getArticlesByCategory($id, $pageSize = null)
    {
      if(is_null($pageSize)){
          $pageSize = Yii::$app->params['pageDefaultSize'];
      }
      $query = Article::find()->where(['category_id' => $id]);
      $count = $query->count();
      $pagination = new Pagination([
          'totalCount' => $count, 
          'pageSize' => $pageSize
      ]);

      $articles = $query->offset($pagination->offset)
      ->limit($pagination->limit)
      ->all();

      $categoryName = Category::getCategoryName($id);

      $data['articles'] = $articles;
      $data['pagination'] = $pagination;
      $data['categoryName'] = $categoryName;

      return $data;
    }
}
