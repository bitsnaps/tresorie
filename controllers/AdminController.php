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
            '/user/admin/pallier/allPalliers',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
    public function actionCreatePallier(){
    
        $grade = $this->make(Grade::class, [], ['scenario' => 'create']);

        return $this->render('/user/admin/pallier/createpallier', ['grade' => $grade]);
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

            return $this->render('/user/admin/pallier/createpallier', ['grade' => $grade]);
        }

       
    }
     /**
     * Displays a single Grade model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('/user/admin/pallier/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Grade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/user/admin/pallier/view', 'id' => $model->id]);
        }

        return $this->render('/user/admin/pallier/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Grade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/admin/pallier/palliers']);
    }

    /**
     * Finds the Grade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grade::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


   
    
}