<?php

namespace app\controllers;

use yii\web\NotFoundHttpException;
use Da\User\Controller\AdminController as BaseController;
use app\models\UserSearch;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Decaissement;
use app\models\DecaissementSearch;
use app\models\Decaissementhistorique;
use app\models\Transaction;
use app\models\User;
use yii\web\UploadedFile;
use app\models\Role;
use Yii;

class DecaissementController extends BaseController
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
                            if (User::isAdmin()) {
                                return  true;
                            }
                            return false;
                        },
                    ],
                    [
                        'actions' => ['view', 'search', 'index', 'update-decaissement', 'delete-decaissement', 'confirm-decaissement', 'block-decaissement'],
                        'allow' => true,
                        'roles' => [Yii::$app->params['roles'][1]]
                    ],
                    [
                        'actions' => ['view', 'search', 'index','create'],
                        'allow' => true,
                        'roles' => [Yii::$app->params['roles'][2]]
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {

        //case admin
        if (User::isAdmin()) {
            $searchModel = $this->make(DecaissementSearch::class);
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        }
        if (User::isAprobateur()) {

            $searchModel = $this->make(DecaissementSearch::class);
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        }
        if (User::isResponsableDeStation()) {

            $searchModel = $this->make(DecaissementSearch::class);
            $dataProvider = $searchModel->searchDemandesUtilisateur(\Yii::$app->request->queryParams, User::getCurrentUser()->id);
        }

        return $this->render(
            '/user/admin/decaissement/index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
    /**
     * Updates an existing Decaissement model.
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
     * Displays a single Decaissement model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        return $this->render('/user/admin/decaissement/view', [
            'model' => $this->findModelDecaissement($id),
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
     * This methode confirm decaissement aproved by an admin or an approbateur
     *
     * @return void
     */
    public function actionConfirmDecaissement($id)
    {
        $model = Decaissement::findOne(['id' => $id]);

        $model->status_admin = 1;

        if ($model->update()) {

            $transaction = new Transaction();
            $transaction->date_transaction = $model->date_demande;
            $transaction->montant = $model->montant;
            $transaction->decaissement_id = $model->id;
            $transaction->approved_by = User::getCurrentUser()->id;
            if ($transaction->save()) {
                \Yii::$app->session->setFlash('success', 'La demande a été approuver correctement et archiver dans transactions.');
            } else {

                throw new NotFoundHttpException(\Yii::t('app', 'Vous pouvez pas archiver votre demande de transaction'));
            }
        } else {

            throw new NotFoundHttpException(\Yii::t('app', 'Vous pouvez pas archiver votre demande de transaction'));
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

        if ($model->status_admin == 0 or $model->status_admin == 1)
            $model->status_admin = 2;
        else
            $model->status_admin = 0;


        if ($model->update()) {
        } else {
            throw new NotFoundHttpException(403, Yii::t('app', 'Vous pouvez pas Blocker cette demande'));
        }
        return $this->redirect(['/admin/decaissement']);
    }
    /*Responsable De Station*/
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
    public function actionCreate()
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

            AccountNotification::create(AccountNotification::KEY_DEMAMDE_DECAISEMENT, ['user' => $user, 'decaissement_id' => $decaissement_id, 'decaissement_motif' => $decaissement_motif, 'decaissement_montant' => $decaissement_montant, 'username' => $username])->send();

            \Yii::$app->session->setFlash('success', 'Votre demande a éte crée avec success');

            return $this->redirect(['/decaissement']);
        } else {

            return $this->render('/user/admin/decaissement/create', ['decaissement' => $model]);
        }
    }

    /**
     * methode finding a specifique  Decaissement
     *
     * @param [type] $id
     * @return object
     */
    protected function findModelDecaissement($id)
    {
        if (($model = Decaissement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
