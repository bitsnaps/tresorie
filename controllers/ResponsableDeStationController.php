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
use yii\web\UploadedFile;


//require_once 'notifications.php';

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
                        'roles' => ['Utilisateur'],
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
        $dataProvider = $searchModel->searchDemandesUtilisateur(\Yii::$app->request->queryParams, User::getCurrentUser()->id);

        return $this->render(
            '/user/admin/decaissement/allDecaissementResponsable',
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
     * sauvgarder une demande de decaissement
     *
     * @param [object] $model
     * @return object
     */
    public function saveDecaissement($model)
    {
        //Assigning Attribute to the model
        $now = new \DateTime();
        $model->date_demande = $now->format('Y-m-d H:i:s');
        if ($model->piece_jointe != 'vide' and !empty($model->piece_jointe)) {
            if ($model->upload()) {
                //return true;
            }
        }
        if ($model->piece_jointe) {
            $model->piece_jointe = UploadedFile::getInstance($model, 'piece_jointe');
        } else {
            $model->piece_jointe = "vide";
        }
        $model->sender_user_id = User::getCurrentUser()->id;
        //Saving Decaissement model
        if ($model->save(false)) {
            return $model;
        } else {
            throw new \yii\web\HttpException(404, 'On a pas pu sauvgarder votre demande de decaissement.');
        }
    }
    /**
     * sauvgarder l'historique  d'une demande de decaissement qui sera attribuer a tous les aprobateur
     *
     * @param [object] $model
     * @param [object] $model1
     * @param [integer] $individualRole
     * @return void
     */
    public function saveDecaissementHistorique($model, $model1, $individualRole = null)
    {
        //Decaissement historique model
        $now = new \DateTime();
        $model1->date_demande = $now->format('Y-m-d H:i:s ');
        $model1->montant = $model->montant;
        $model1->motif =  $model->motif;
        if ($model->piece_jointe) {
            $model1->piece_jointe = UploadedFile::getInstance($model, 'piece_jointe');
        }
        $model1->id = $model->id;
        $model1->piece_jointe = "vide";
        $model1->sender_user_id = User::getCurrentUser()->id;
        $model1->reciever_user_id = User::getCurrentUser()->id;

        if ($model1->save(false)) {
        } else {
            //print_r($model1->errors);
            throw new \yii\web\HttpException(404, 'On a pas pu sauvgarder votre demande de decaissement.');
        }
    }
    /**
     * This function create a pallier for a specific user assigned by an admin
     *
     * @return void
     */
    public function actionCreateDemande()
    {

        $model = new Decaissement();
        $model1 = new Decaissementhistorique();
        $counter = 0;
        if ($model->load(\Yii::$app->request->post())) {
            $model = $this->saveDecaissement($model);
            $this->saveDecaissementHistorique($model, $model1);
            $decaissement_id = $model->id;
            $decaissement_montant = $model->montant;
            $decaissement_motif = $model->motif;
            $username = $model->senderUser->username;
            $user = \app\models\User::find()->where(['id' => User::getCurrentUser()->id])->one();

            //AccountNotification::create(AccountNotification::KEY_DEMAMDE_DECAISEMENT, ['user' => $user, 'decaissement_id' => $decaissement_id, 'decaissement_motif' => $decaissement_motif, 'decaissement_montant' => $decaissement_montant, 'username' => $username])->send();

            \Yii::$app->session->setFlash('success', 'Votre demande a éte crée avec success');

            return $this->redirect(['/responsable-de-station/decaissement']);
      
        } else {

            return $this->render('/user/admin/decaissement/createdecaissement', ['decaissement' => $model]);
        }
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
            \Yii::$app->session->setFlash('success', 'Pallier cree avec success');

            return $this->render('/user/admin/pallier/createpallier', ['grade' => $grade]);
        }
    }
    /**
     * function to view Decaissement
     */
    public function actionViewDecaissement($id)
    {

        return $this->render('/user/admin/decaissement/view', [
            'model' => $this->findModelDecaissement($id),
        ]);
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

    protected function findModelDecaissement($id)
    {
        if (($model = Decaissement::findOne($id)) !== null) {
            return $model;
        }

        throw new \NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
