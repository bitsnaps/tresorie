<?php
// ...
namespace app\controllers;

use  Da\User\Controller\AdminController as BaseController;
use yii\web\Controller;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Grade;
use app\models\GradeSearch;
use app\models\Decaissement;
use app\models\DecaissementSearch;
use app\models\Decaissementhistorique;

include 'notifications.php';

use app\models\Role;

// ...

class ResponsableDeStationController extends BaseController
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
                        'roles' => ['responsableDeStation'],
                    ],
                ],
            ],
        ];
    }
    /**
     * This function return all palliers assigned by the admin
     *
     * @return void
     */
    public function actionDecaissement()
    {

        $searchModel = $this->make(DecaissementSearch::class);
        $dataProvider = $searchModel->searchMyDemande(\Yii::$app->request->queryParams, User::getCurrentUser()->id);

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
    public function actionConfirmDecaissement($id)
    {
        $model = Decaissement::findOne(['id' => $id]);

        if ($model->status_admin == 0)
            $model->status_admin = 2;
        else
            $model->status_admin = 0;

        if ($model->update()) {
        } else {
            print_r($model->errors);
            die();
        }

        return $this->redirect(['/admin/decaissement']);
    }

    /**
     * This methode block decaissement aproved by an admin or an approbateur
     *
     * @return void
     */
    public function actionBlockDecaissement($id)
    {
        $model = Decaissement::findOne(['id' => $id]);

        if ($model->status_admin == 0 or $model->status_admin == 2)
            $model->status_admin = 1;
        else
            $model->status_admin = 0;


        if ($model->update()) {
        } else {
            print_r($model->errors);
            die();
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
    public function actionPalliers()
    {

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
    public function actionCreateDemande($id = null)
    {

        $model = new Decaissement();
        $model1=new Decaissementhistorique();
        //Ajax
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            //data: { 'save_id' : fileid },
            $now = new \DateTime();
            $model->date_demande = $now->format('Y-m-d H:i:s');;
            $model->montant = $data['montant'];
            $model->motif = $data['motif'];
            $model->piece_jointe = $data['piece_jointe'];
            $model->user_id = User::getCurrentUser()->id;
//Decaissement historique

            $model1->date_demande = $now->format('Y-m-d H:i:s');;
            $model1->montant = $data['montant'];
            $model1->motif = $data['motif'];
            $model1->piece_jointe = $data['piece_jointe'];
            $model1->user_id = User::getCurrentUser()->id;

            if ($model->save()) {
             
                $model1->id= $model->id;
                if ($model1->save()) {
                    
                }else{
                    print_r($model1->errors);
                    echo json_encode(['status' => 'Error', 'message' => 'Demande no valide']);
                }

                $decaissement_id=$model->id;
                $decaissement_montant=$model->montant;
                $decaissement_motif=$model->motif;
                $username= $model->user ->username;
                $user = \app\models\User::find()->where(['id' => User::getCurrentUser()->id])->one();
                echo json_encode(['status' => 'Success', 'message' => 'Demande valide', 'id' => $model->id]);
                AccountNotification::create(AccountNotification::KEY_DEMAMDE_DECAISEMENT, ['user' =>$user,'decaissement_id'=>$decaissement_id,'decaissement_motif'=>$decaissement_motif,'decaissement_montant'=>$decaissement_montant,'username'=>$username])->send();
                die();
            } else {
                print_r($model->errors);
                echo json_encode(['status' => 'Error', 'message' => 'Demande no valide']);
            }
        }
        //Dans le cas apres il a confirmer 
        if ($model->load(\Yii::$app->request->post()) and $model->validate()) {
            $model =  Decaissement::find()->where(['id' => $id])->one();
            $model1 =  Decaissementhistorique::find()->where(['id' => $id])->one();

            $model->status_user = 1;
            $model1->status_user = 1;
            if ($model->update() and $model1->update()) {
                $decaissement_id=$model->id;
                $decaissement_montant=$model->montant;
                $decaissement_motif=$model->motif;
                $username= $model->user ->username;
                $user = \app\models\User::find()->where(['id' => User::getCurrentUser()->id])->one();

                AccountNotification::create(AccountNotification::KEY_DEMAMDE_DECAISEMENT, ['user' =>$user,'decaissement_id'=>$decaissement_id,'decaissement_motif'=>$decaissement_motif,'decaissement_montant'=>$decaissement_montant,'username'=>$username])->send();
                echo json_encode(['status' => 'Success', 'message' => 'Demande valider']);
            } else {
                print_r($model->errors);

                echo json_encode(['status' => 'Error', 'message' => 'Demande no valide']);
            }
        }else{
            $decaissement = $this->make(Decaissement::class, [], ['scenario' => 'create']);

            return $this->render('/user/admin/decaissement/createdecaissement', ['decaissement' => $decaissement]);
        }
        $decaissement = $this->make(Decaissement::class, [], ['scenario' => 'create']);

        return $this->render('/user/admin/decaissement/createdecaissement', ['decaissement' => $decaissement]);
        


       
    }
    /**
     * This Methode is responsible on saving a pallier
     *
     * @return void
     */
    public function actionSavePallier()
    {

        $model = new Grade();
        $role = new Role();
        $grade = $this->make(Grade::class, [], ['scenario' => 'create']);
        if ($model->load(\Yii::$app->request->post())) {
            //need to create role for the aprobateur or any other specifique user 
            $role->role_name = $model->role_id;
            $role->user_id = $model->user_id;

            if ($role->save()) {
            } else {

                print_r($role->errors);
                die();
            }
            //saving the grade with it specifique pallier
            $model->role_id = $role->id;
            if ($model->save()) {
            } else {
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
