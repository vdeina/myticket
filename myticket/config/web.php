<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
         'baseUrl'=> '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'K2u4mGO7pt61krH8Jo5M_O0YFmtYtXcH',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            'index'=>'site/index',
            'main'=>'site/main',
            'logout'=>'site/logout',
            'tickets'=>'site/tickets',
            'action-tickets'=>'site/action-tickets',
            'add-record'=>'site/add-record',
            'agents'=>'site/agents',
            'reports'=>'site/reports',
            'carriers'=>'site/carriers',
            'payments'=>'site/payments',
            'agents-reports'=>'site/agents-reports',
            'aviacompanies-reports'=>'site/aviacompanies-reports',
            'currency-rate'=>'site/currency-rate',
            'payments-carriers'=>'site/payments-carriers',
            'payments-agents'=>'site/payments-agents',
            'ticket-details/<record:\w+>'=>'site/ticket-details'
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /*$config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];*/

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
