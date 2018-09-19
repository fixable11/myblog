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
    
    /**
     * Article table relation
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }
    
    /**
     * Gets all categories
     * 
     * @return array Array of all categories
     */
    public static function getAllCategories()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'title');
    }
    
    /**
     * Gets amount of articles
     * 
     * @return int Count of articles
     */
    public function getArticlesCount()
    {
        return $this->getArticles()->count();
    }
    
    /**
     * Gets all categories
     * 
     * @return yii\db\ActiveRecord
     */
    public static function getAll()
    {
        return Category::find()->with('articles')->all();
    }
    
    /**
     * Gets category name by id
     * 
     * @param int $id Category id
     * @return yii\db\ActiveRecord
     * @throws \yii\web\NotFoundHttpException
     */
    public static function getCategoryName($id)
    {
      if(!intval($id)){
        throw new \yii\web\NotFoundHttpException();
      }
      return Category::find()->where(['id' => $id])->one()->title;

    }
    
    /**
     * Gets list of articles by category id
     * 
     * @param type $id Category id
     * @param int $pageSize Amaount of articles per page 
     * @return array $data Array contains: articles, pagination and category name
     */
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
