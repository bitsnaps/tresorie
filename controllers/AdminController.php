<?php
// ...
namespace app\controllers;
use  Da\User\Controller\AdminController as BaseController;
use app\models\UserSearch;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Grade;
use app\models\GradeSearch;
use app\models\Decaissement;
use app\models\DecaissementSearch;
use app\models\Transaction;
use app\models\User;
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
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if(User::isAdmin())
                            return  true;
                            return false;
                        },
                    ],
                    [
                        'actions' => ['view', 'search','decaissement','view-decaissement','update-decaissement','delete-decaissement','confirm-decaissement','block-decaissement'],
                        'allow' => true,
                        'roles' => ['Approbateur','Administrateur','Utilisateur'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $searchModel = $this->make(UserSearch::class);
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }
         /**
     * Displays a single Grade model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewDecaissement($id)
    {
      
        return $this->render('/user/admin/decaissement/view', [
            'model' => $this->findModelDecaissement($id),
        ]);
    }

    /**
     * Updates an existing Grade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateDecaissement($id)
    {
        $model = $this->findModelDecaissement($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/user/admin/decaissement/view', 'id' => $model->id]);
        }

        return $this->render('/user/admin/decaissement/update', [
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
    public function actionDeleteDecaissement($id)
    {
        $this->findModelDecaissement($id)->delete();

        return $this->redirect(['/admin/decaissement']);
    }
        /**
     * This function return all palliers assigned by the admin
     *
     * @return void
     */
    public function actionDecaissement(){
        
        //case admin
        if(User::isAdmin()){
            $searchModel = $this->make(DecaissementSearch::class);
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        }
        if(User::isAprobateur()){
          
            $searchModel = $this->make(DecaissementSearch::class);
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        }
        if(User::isResponsableDeStation()){
           
            $searchModel = $this->make(DecaissementSearch::class);
             $dataProvider = $searchModel->searchDemandesUtilisateur(\Yii::$app->request->queryParams,User::getCurrentUser()->id);
        }
        

        return $this->render(
            '/user/admin/decaissement/allDecaissement',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * This methode confirm decaissement aproved by an admin or an approbateur
     *
     * @return void
     */
    public function actionConfirmDecaissement($id){
        $model=Decaissement::findOne(['id'=>$id]);
        
        if($model->status_admin==0)
             $model->status_admin=2;
        else
            $model->status_admin=0;

        if($model->update()){
            //
            $transaction=new Transaction();
            $transaction->date_transaction=$model->date_demande;
            $transaction->montant=$model->montant;
            $transaction->decaissement_id=$model->id;
            $transaction->approved_by= User::getCurrentUser()->id;
            if($transaction->save()){
                \Yii::$app->session->setFlash('success','La demande a été approuver correctement et archiver dans transactions.');
            }else{
                throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas archiver votre demande de transaction'));
            }
        }else{
            throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas archiver votre demande de transaction'));
        }

        return $this->redirect(['/admin/decaissement']);
        
    }

    /**
     * This methode block decaissement aproved by an admin or an approbateur
     *
     * @return void
     */
    public function actionBlockDecaissement($id){
        $model=Decaissement::findOne(['id'=>$id]);
        
        if($model->status_admin==0 or $model->status_admin==2)
            $model->status_admin=1;
        else
            $model->status_admin=0;
        

        if($model->update()){

        }else{
            throw new \yii\web\NotFoundHttpException(403,Yii::t('app', 'Vous pouvez pas Blocker cette demande'));
        }

        return $this->redirect(['/admin/decaissement']);
    }

    /**
     * ALL Methodes Responsible On Palliers
     *
     * 
     */  

    /**
     * This function return all palliers assigned by the admin
     *
     * @return void
     */
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
    /**
     * This function create a pallier for a specific user assigned by an admin
     *
     * @return void
     */
    public function actionCreatePallier(){
    
        $model =new Grade();
        $role =new Role();
        $grade = $this->make(Grade::class, [], ['scenario' => 'create']);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //need to create role for the aprobateur or any other specifique user 
            $role->role_name=$model->role_id;
            $role->user_id=$model->user_id;
  
            if($role->save()){
                //AuthUpdate
               // $auth=\app\models\AuthAssignment::find()->where(['user_id'=>$model->user_id])->one();
               // $auth->item_name='Approbateur';
             //   $auth->update();
            }else{
               
                throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas crée cette pallier'));
            }
            //saving the grade with it specifique pallier
            $model->role_id= $role->id;
            if($model->save()){

            }else{
                throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas crée ce role'));
            }

            \Yii::$app->session->setFlash('success','Grade  crée avec success');


            return $this->render('/user/admin/pallier/createpallier', ['grade' => $grade]);
        }else{
            
            return $this->render('/user/admin/pallier/createpallier', ['grade' => $model]);
        }
    }
    /**
     * This Methode is responsible on saving a pallier
     *
     * @return void
     */
    public function actionSavePallier(){
    
        $model =new Grade();
        $role =new Role();
        $grade = $this->make(Grade::class, [], ['scenario' => 'create']);
        if ($model->load(\Yii::$app->request->post())) {
            //need to create role for the aprobateur or any other specifique user 
            $role->role_name=$model->role_id;
            $role->user_id=$model->user_id;
  
            if($role->save()){

            }else{
                throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas crée cette pallier'));
            }
         
            $model->role_id= $role->id;
            if($model->save()){
            }else{
                throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas crée ce role'));
            }

            \Yii::$app->session->setFlash('success','Pallier et Approbateur crée avec success');


            return $this->render('/user/admin/pallier/createpallier', ['grade' => $grade]);
        }else{
            
             $errors = $model->errors;
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
        $id=$model->role_id;
        if ($model->load(\Yii::$app->request->post())) {

 
            $model->role_id=$id;
            if($model->save()){
            }else{
                throw new \yii\web\NotFoundHttpException(403,\Yii::t('app', 'Vous pouvez pas faire cette modification de grade'));
            }
            return $this->redirect(['/admin/view', 'id' => $model->id]);
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

        return $this->redirect(['/admin/palliers']);
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
    protected function findModelDecaissement($id)
    {
        if (($model = Decaissement::findOne($id)) !== null) {
            return $model;
        }

        throw new \NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


   
    
}