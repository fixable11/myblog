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
    public $popular = null;
    
    /**
     * @var array|ActiveQuery[] the recent articles by added date.
     */
    public $recent = null;
    
    /**
     * @var array|ActiveQuery[] the all existing categories.
     */
    public $categories = null;
    
    /**
     * @var app/models/SubscribeForm the model for subscribe functionality
     */
    public $subModel = null;
    
    /**
     * @var 
     */
    public $tags = null;

    /**
     * {@inheritdoc}
     */
    public function run()
    {

      $array = [];
      if(isset($this->popular)){
        $array['popular'] = $this->popular;
      }
      if(isset($this->recent)){
        $array['recent'] = $this->recent;
      }
      if(isset($this->categories)){
        $array['categories'] = $this->categories;
      }
      if(isset($this->subModel)){
        $array['subModel'] = $this->subModel;
      }
      if(isset($this->tags)){
        $array['tags'] = $this->tags;
      }
        
      return $this->render('/widgets/sidebar', $array);
    }
}
