<?php

namespace app\controllers;

use app\models\User;
use app\models\Transaction;
use app\models\TransactionSearch;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


use  Da\User\Controller\AdminController as BaseController;

class TransactionController extends BaseController
{
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
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRuleFilter::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if(User::isAdmin())
                            return  true;
                            return false;
                        },
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $searchModel = $this->make(TransactionSearch::class);
        //case not admin

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render(
            '/user/admin/transaction/index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

}
