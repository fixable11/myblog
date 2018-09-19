<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Faker\Factory;
use Yii;
use app\models\Article;

class TestController extends Controller
{
  public function actionGenerateArticle()
  {
    
    for($i = 1; $i <= 10; $i++){
      $faker = Factory::create();
      $articleModel = new Article();
      $articleModel->title = $faker->text(35);
      $articleModel->description = $faker->text(100);
      $articleModel->content = $faker->text(rand(1000, 2000));
      $articleModel->date = date('Y-m-d H:i:s');
      $articleModel->user_id = Yii::$app->user->id;
      $articleModel->status = 1;
      $articleModel->save(false);
    }
    
    

  }
   
}
