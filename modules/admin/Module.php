<?php

namespace app\modules\admin;

use yii\filters\AccessControl;
use Yii;
/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{

  /**
   * {@inheritdoc}
   */
  public $controllerNamespace = 'app\modules\admin\controllers';
  public $layout = '@app/views/layouts/admin';

  /**
   * {@inheritdoc}
   */
  public function init()
  {
    parent::init();

    // custom initialization code goes here
  }

  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'denyCallback' => function($rule, $action)
            {
              throw new \yii\web\NotFoundHttpException();
            },
            'rules' => [
                [
                    'allow' => true,
                    'matchCallback' => function($rule, $action)
                    {
                      if(isset(Yii::$app->user->identity->isAdmin)){
                        return Yii::$app->user->identity->isAdmin;
                      }
                      return false;
                    }
                ]
            ]
        ]
    ];
  }

}
