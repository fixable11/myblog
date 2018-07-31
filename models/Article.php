<?php

namespace app\models;

use Yii;
use app\models\Category;
use yii\helpers\ArrayHelper;
use app\models\ArticleTag;

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
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
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
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }
    
    public function saveImage($filename)
    {
        $this->image = $filename;
        $this->save(false);
    }
    
    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }
    
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
        if($this->image){
            return '/uploads/' . $this->image;
        }
        
        return '/default.jpg';
    }
    
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    
    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);
        if($category != null){
            $this->link('category', $category);
            return true;
        }
        
    }
    
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }
    
    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return  ArrayHelper::getColumn($selectedIds, 'id');
    }
    
    public function saveTags($tags)
    {
        if(is_array($tags)){
            
            $this->deleteCurrentTags();
            
            foreach($tags as $tag_id){
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }
    
    public function deleteCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }
    
    
}
