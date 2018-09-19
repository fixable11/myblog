<?php

namespace app\models;

use Yii;
use app\models\Category;
use yii\helpers\ArrayHelper;
use app\models\ArticleTag;
use yii\data\Pagination;
use app\models\User;
use app\models\Likes;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 * @property int $like_up
 * @property int $like_down
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'article';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['title'], 'required'],
        [['title', 'description', 'content'], 'string'],
        [['title', 'description', 'content'], 'required'],
        [['date'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        [['date'], 'default', 'value' => date('Y-m-d H:i:s')],
        [['title'], 'string', 'max' => 255],
        ['status', 'default', 'value' => 1],
        [['image'], 'file', 'extensions' => 'jpg,png', 'maxSize' => 1024 * 1024 * 2],
        [['image'], 'image', 'minWidth' => 100, 'maxWidth' => 1000, 'minHeight' => 100, 'maxHeight' => 1000],
        [['like_up'], 'safe'],
        [['like_down'], 'safe'],
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
        'description' => 'Description',
        'content' => 'Content',
        'date' => 'Date',
        'image' => 'Image',
        'viewed' => 'Viewed',
        'user_id' => 'User ID',
        'status' => 'Status',
        'category_id' => 'Category ID',
        'like_up' => 'Like Up',
        'like_down' => 'Like Down',
    ];
  }

  /**
   * article_tag table relation
   * 
   * @return \yii\db\ActiveQuery
   */
  public function getArticleTags()
  {
    return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
  }

  /**
   * comment table relation
   * 
   * @return \yii\db\ActiveQuery
   */
  public function getComments()
  {
    return $this->hasMany(Comment::className(), ['article_id' => 'id']);
  }
  
  /**
   * Save image for specific article
   * 
   * @param string $filename Filename
   */
  public function saveImage($filename)
  {
    $this->image = $filename;
    $this->save(false);
  }
  
  /**
   * Delete current image if it exists
   */
  public function deleteImage()
  {
    $imageUploadModel = new ImageUpload();
    $imageUploadModel->deleteCurrentImage($this->image);
  }
  
  /**
   * Deletes image before delete article
   */
  public function beforeDelete()
  {
    $this->deleteImage();
    return parent::beforeDelete();
  }

  /**
   * Returns the current image if it exists. 
   * Otherwise returns the default image.
   * 
   * @return string Image name
   */
  public function getImage()
  {
    if ($this->image) {
      return '/' . Yii::getAlias('@web') 
      . Yii::$app->params['article_images_folder'] 
      . $this->id . '/'
      . $this->image;
    }

    return '/' . Yii::$app->params['images_folder'] . '/' . Yii::$app->params['default_no_image'];
  }

  /**
   * category table relation
   * 
   * @return \yii\db\ActiveQuery
   */
  public function getCategory()
  {
    return $this->hasOne(Category::className(), ['id' => 'category_id']);
  }
  
  /**
   * tag table relation via article_tag
   * 
   * @return \yii\db\ActiveQuery
   */
  public function getTags()
  {
    return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
    ->viaTable('article_tag', ['article_id' => 'id']);
  }
  
  /**
   * Returns set of related tags
   * 
   * @return array
   */
  public function getSelectedTags()
  {
    $selectedIds = $this->getTags()->select('id')->asArray()->all();
    return ArrayHelper::getColumn($selectedIds, 'id');
  }
  
  /**
   * Populates set of tags for specific article
   * 
   * @param array $tags
   */
  public function saveTags($tags)
  {
    if (is_array($tags)) {

      $this->deleteCurrentTags();

      foreach ($tags as $tag_id) {
        $tag = Tag::findOne($tag_id);
        $this->link('tags', $tag);
      }
    }
  }
  
  /**
   * Deletes current tags of specific article
   */
  public function deleteCurrentTags()
  {
    ArticleTag::deleteAll(['article_id' => $this->id]);
  }
  
  /**
   * Returns date as formatted data that depends on user's timezone
   * 
   * @param type $offset timezone offset
   * @return type
   */
  public function getDate($offset = 0)
  {
    $timestamp = strtotime($this->date);
    $date = $timestamp + $offset * 60 * 60;
    return Yii::$app->formatter->asDate($date, 'dd.MM.yyyy в HH:mm:ss');
  }

  /**
   * The method returns pagination data and the appropriate Article model 
   * 
   * @param int $pageSize Page size
   * 
   * @return array $array['articles'] = [[ActiveQuery]], 
   * $array['pagination'] = [[Pagination]]
   */
  public static function getAll($pageSize = null)
  {
    if (is_null($pageSize)) {
      $pageSize = Yii::$app->params['pageDefaultSize'];
    }

    $query = Article::find()
    ->with('author')
    ->with('comments')
    ->with('category')
    ->where(['status' => 1]);
    
    $count = $query->count();
    $pagination = new Pagination([
        'totalCount' => $count,
        'pageSize' => $pageSize
    ]);

    $articles = $query->offset($pagination->offset)
    ->orderBy('id desc')
    ->limit($pagination->limit)
    ->all();

    $data['articles'] = $articles;
    $data['pagination'] = $pagination;

    return $data;
  }
  
  /**
   * Returns set of popular articles
   * 
   * @return \yii\db\ActiveRecord
   */
  public static function getPopular($limit)
  {
    return Article::find()->with('comments')->orderBy('viewed desc')->limit($limit)->all();
  }
  
  /**
   * Returns set of last added articles
   * 
   * @return \yii\db\ActiveRecord
   */
  public static function getRecent()
  {
    return Article::find()->orderBy('date desc')->limit(Yii::$app->params['recentLimit'])->all();
  }
  
  /**
   * Saves article
   * 
   * @return bool
   */
  public function saveArticle()
  {
    $this->user_id = Yii::$app->user->id;
    return $this->save();
  }
  
  /**
   * Returns set of comments of specific article
   * where status = 1
   * 
   * @return \yii\db\ActiveRecord
   */
  public function getArticleComments()
  {
    return $this->getComments()->where(['status' => 1])->all();
  }
  
  /**
   * Returns author of article
   * 
   * @return \yii\db\ActiveRecord
   */
  public function getAuthor()
  {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
  }
  
  /**
   * Increment of the views' counter at each viewing of article
   * 
   * @return \yii\db\ActiveRecord
   */
  public function viewedCounter()
  {
    $this->viewed += 1;
    return $this->save(false);
  }
  
  /**
   * Checks whether user can put a like.
   * If yes, then increases a like counter
   * 
   * @return boolean
   */
  public function likeUp()
  {
    $likesModel = new Likes();
    $model = Likes::findOne(['article_id' => $this->id, 'user_id' => Yii::$app->user->id]);
    if($model){
      if(!$model->liked){
        $this->whetherReduceArticleDislikes($model);
        $model->liked = 1;
        $model->disliked = 0;
        $model->save();
        
        $this->like_up += 1;
        return $this->save();
      }
      return false;
    } else {
      if($likesModel->doLike()){
        $this->like_up += 1;
        return $this->save();
      }
      return false;
    } 
  }
  
  /**
   * Checks whether user can put a dislike.
   * If yes, then increases a dislike counter
   * 
   * @return boolean
   */
  public function likeDown()
  {
    $likesModel = new Likes();
    $model = Likes::findOne(['article_id' => $this->id, 'user_id' => Yii::$app->user->id]);
    if($model){
      if(!$model->disliked){
        $this->whetherReduceArticleLikes($model);  
        $model->disliked = 1;
        $model->liked = 0;
        $model->save();
        
        $this->like_down += 1; 
        return $this->save();
      }
      return false;
    } else {
      if($likesModel->doDislike()){
        $this->like_down += 1;
        return $this->save();
      }
      return false;
    } 
  }
  
  /**
   * If user has already put like and wants to put dislike, 
   * then method reduce amount of likes by 1
   * 
   */
  private function whetherReduceArticleLikes($model)
  {
    if($model->liked){
      $this->like_up -= 1;
    }
  }
  
  /**
   * If user has already put dislike and wants to put like, 
   * then method reduce amount of dislikes by 1
   * 
   */
  private function whetherReduceArticleDislikes($model)
  {
    if($model->disliked){
      $this->like_down -= 1;
    }
  }
  
  /**
   * Returns amount of article's likes
   * 
   * @return int
   */
  public function likesAmount()
  {
    return $this->like_up;
  }
  
  /**
   * Returns amount of article's dislikes
   * 
   * @return int
   */
  public function dislikesAmount()
  {
    return $this->like_down;
  }

}
