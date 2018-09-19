<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\ArticleSearch;

class SearchForm extends Model
{
    public $keyword;
    
    public function rules()
    {
        return [
            ['keyword', 'trim'],
            ['keyword', 'required'],
            ['keyword', 'string', 'min' => 3],
        ];
    }
    
    public function search()
    {
      if($this->validate()){
        $model = new ArticleSearch();
        return $model->fulltextSearch($this->keyword);
      }      
      
    }
    
}