<?php
// ...
namespace app\controllers;
use yii\web\Controller;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use dektrium\user\filters\AccessRule;
use app\models\User;

// ...

class FiltrerController extends Controller
{



    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'confirm' => ['post'],
                    'block' => ['post'],
                ],
            ],

                'access' => [
                    'class' => AccessControl::className(),
                    'ruleConfig' => [
                        'class' => AccessRule::className(),
                    ],
                    'rules' => [
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'actions' => ['view', 'search','filter-authenticated-user'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ];
     
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionFilterAuthenticatedUser(){
     //   var_dump(User::getCurrentUser());
      var_dump(User:: userHasRole('admin',User::getCurrentUser()->id));

      print_r(\Yii::$app->authManager->getRolesByUser(User::getCurrentUser()->id) );
       
       die();

    }


   
    
}