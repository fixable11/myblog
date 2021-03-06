<?php

$params = array_merge(
  require (__DIR__ . '/params.php'),
  require (__DIR__ . '/params-local.php')
);

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Treasure Blog',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'UTC',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'u7HgEOxixNFKZHfv4AyrM7y9QIVG-Px_',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'site/tags/<tag>' => 'site/tags',
            ],
        ],
        
        'assetManager' => [
            'bundles' => [
                'yii\boostrap4\BootstrapAsset' => [
                    'sourcePath' => '@npm/bootstrap/dist'
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'sourcePath' => '@npm/bootstrap/dist'
                ],
                //'yii\web\JqueryAsset' => false,
                //'yii\bootstrap\BootstrapAsset' => false,
                
            ]
        ],
        
        'common' => [
            'class' => 'app\components\Common',
        ],
        
        'formatter' => [
          'dateFormat' => 'dd.MM.yyyy',
          'timeFormat' => 'H:mm:ss',
          'datetimeFormat' => 'd.MM.yyyy H:mm:ss',
          'defaultTimeZone' => 'UTC',
        ],
        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'article/index',
        ],
    ],
    
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'path' => 'images/posts',
                'name' => 'Files'
            ],
        ],
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    
    'params' => $params,
    
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
