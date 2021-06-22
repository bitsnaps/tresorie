<?php
// ...
namespace app\controllers;
use  Da\User\Controller\AdminController as BaseController;
use yii\web\Controller;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Grade;
use app\models\GradeSearch;
use app\models\Role;

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
    public function actionPalliers(){
    
        $searchModel = $this->make(GradeSearch::class);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render(
            '/user/admin/allPalliers',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
    public function actionCreatePallier(){
    
        $grade = $this->make(Grade::class, [], ['scenario' => 'create']);

        return $this->render('/user/admin/createpallier', ['grade' => $grade]);
    }
    public function actionSavePallier(){
    
        $model =new Grade();
        $role =new Role();
        $grade = $this->make(Grade::class, [], ['scenario' => 'create']);
        if ($model->load(\Yii::$app->request->post()) ) {
            //need to create role for the aprobateur or any other specifique user 
            $role->role_name=$model->role_id;
            $role->user_id=$model->user_id;
  
            if($role->save()){

            }else{
               
                print_r($role->errors);
                die();
            }
            //saving the grade with it specifique pallier
            $model->role_id= $role->id;
            if($model->save()){

            }else{
                print_r($model);
                print_r($model->errors);
                die();
            }
            \Yii::$app->session->setFlash('Pallier cree avec success');

            return $this->render('/user/admin/createpallier', ['grade' => $grade]);
        }

       
    }


   
    
}