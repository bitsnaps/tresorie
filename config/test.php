<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'homeUrl'=> array('/site/index'),
    'basePath' => dirname(__DIR__),
    'name' => 'Yalidine',
    'language'=>'fr',
    'defaultRoute' => '/user/security/login',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,

        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
                'webzop\notifications\NotificationsAsset' => [
                    //'sourcePath' => null,

                    'js' => [
                     //   '@web/js/notifications.js'
                    ],
                ]
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => '',
            'decimalSeparator' => '.',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@Da/User/resources/views' => '@app/views/user',
                    '@webzop/notifications/views' => '@app/views/notification'
                ]
            ]
        ],
    ],
    'modules' => [
        'user' => [
            'class' => \Da\User\Module::class,
            //think how to create a component for that
            // ...other configs from here: [Configuration Options](installation/configuration-options.md), e.g.
            'administrators' => ['admin'], // this is required for accessing administrative actions
            // 'generatePasswords' => true,
            // 'switchIdentitySessionKey' => 'myown_usuario_admin_user_key',
            'controllerMap' => [
                'security' => 'app\controllers\user\UserController',
                'admin' => 'app\controllers\user\AdminController',
                'role' => 'app\controllers\user\RoleController'

            ]

        ],
        //Notification
        'notifications' => [
            'class' => 'webzop\notifications\Module',
            'channels' => [
                'screen' => [
                    'class' => 'app\controllers\channels\ScreenChannel',
                ],
                'email' => [
                    'class' => 'webzop\notifications\channels\EmailChannel',
                    'message' => [
                        'from' => 'example@email.com'
                    ],
                ],
            ],

            'controllerMap' => [
                'default' => 'app\controllers\notification\NotificationController',


            ],

        ],

    ],
    'params' => $params,
];
