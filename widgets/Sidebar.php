<?php
namespace app\widgets;

use Yii;
/**
 * Sidebar layout where there are popular posts and recent posts
 */
class Sidebar extends \yii\bootstrap\Widget
{
    /**
     * @var array|ActiveQuery[] the popular articles by amount of view.
     */
    public $popular;
    
    /**
     * @var array|ActiveQuery[] the recent articles by added date.
     */
    public $recent;
    
    /**
     * @var array|ActiveQuery[] the all existing categories.
     */
    public $categories;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if(isset($this->popular) 
        && isset($this->recent) 
        && isset($this->categories)){
            return $this->render('/widgets/sidebar', [
               'popular' => $this->popular,
               'recent' => $this->recent,
               'categories' => $this->categories,
           ]);
        }
    }
}
