<?php

$params = require(__DIR__ . '/params.php');
$adminmenu = require(__DIR__ . '/adminmenu.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'index',
    'aliases' => [
        '@doctorjason/mailerqueue' => '@vendor/doctorjason/mailerqueue/src'
    ],
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'autodetectCluster' => false,
            'nodes' => [
                    ['http_address' => '127.0.0.1:9200'], // configure more hosts if you have a cluster
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_item}}',
            'itemChildTable' => '{{%auth_item_child}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',
            'defaultRoles' => ['category']
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ]
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'q6ga0ArPuP1iWsey2H6aoeWsP7G98FnL',
        ],
        'cache' => [
//            'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 2
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'idParam' => '__user',
            'identityCookie' => ['name' => '__user_indentity', 'httpOnly' => true],
            'loginUrl' => ['/member/auth']
        ],
        'admin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\models\Admin',
            'idParam' => '__admin',
            'identityCookie' => ['name' => '__admin_indentity', 'httpOnly' => true],
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin/public/login']
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            //'class' => 'yii\swiftmailer\Mailer',
            'class' => 'doctorjason\mailerqueue\MailerQueue',
            //redis 0-15
            'db' => '1',
            'key' => 'mails',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => 'imooc_shop@163.com',
                'password' => 'imooc123',
                'port' => '465',
                'encryption' => 'ssl',
            ],
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
        'db' => require(__DIR__ . '/db.php'),
    /*
      'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
      ],
     */
    ],
    'params' => array_merge($params, ['adminmenu' => $adminmenu]),
];

if (YII_ENV_DEV)
{
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1'], //允许访问的ip
    ];
    $config['modules']['admin'] = [
        'class' => 'app\modules\admin', //开启后台模块
    ];
}

return $config;
