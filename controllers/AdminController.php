<?php
// ...
namespace app\controllers;
use  Da\User\Controller\AdminController as BaseController;
use yii\web\Controller;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Grade;

// ...

class AdminController extends BaseController
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
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }
    public function actionCreatePallier(){
        /** @var User $user */
        $grade = $this->make(Grade::class, [], ['scenario' => 'create']);

        /** @var UserEvent $event */
    

        

        return $this->render('/user/admin/createpallier', ['grade' => $grade]);
    }


   
    
}