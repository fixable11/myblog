<?php
namespace app\widgets;

use Yii;
/**
 * Sidebar layout where there are popular posts and recent posts
 */
class Comment extends \yii\bootstrap\Widget
{
    /**
     * @var array|ActiveQuery[] the specific article identified by passed id.
     */
    public $article;
    
    /**
     * @var array|ActiveQuery[] the existing comments that associated with 
     * specific article
     */
    public $comments;
    
    /**
     * @var array|ActiveQuery[] model's instance that works with input form data.
     */
    public $commentForm;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if(isset($this->article) 
        && isset($this->comments) 
        && isset($this->commentForm)){
            return $this->render('/widgets/comment', [
               'article' => $this->article,
               'comments' => $this->comments,
               'commentForm' => $this->commentForm,
           ]);
        }
    }
}
