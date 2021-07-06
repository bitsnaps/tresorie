<?php

namespace app\controllers;

use yii\web\NotFoundHttpException;
use Da\User\Controller\AdminController as BaseController;
use app\models\UserSearch;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Grade;
use app\models\GradeSearch;
use app\models\User;
use app\models\Role;
use Yii;

class GradeController extends BaseController
{
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
    public function actionIndex()
    {

        $searchModel = $this->make(GradeSearch::class);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render(
            '/user/admin/grade/index',
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
    public function actionCreate()
    {

        $model = new Grade();
        $role = new Role();
        $grade = $this->make(Grade::class, [], ['scenario' => 'create']);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //need to create role for the aprobateur or any other specifique user
            $role->role_name = $model->role_id;
            $role->user_id = $model->user_id;

            if ($role->save()) {
            } else {

                throw new NotFoundHttpException(403, \Yii::t('app', 'Vous pouvez pas crée cette pallier'));
            }
            //saving the grade with it specifique pallier
            $model->role_id = $role->id;
            if ($model->save()) {
            } else {
                throw new NotFoundHttpException(403, \Yii::t('app', 'Vous pouvez pas crée ce role'));
            }

            \Yii::$app->session->setFlash('success', 'Grade  crée avec success');


            return $this->redirect(['/grade']);
        } else {

            return $this->render('/user/admin/grade/create-palier', ['grade' => $model]);
        }
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
        $id = $model->role_id;
        $model->role_id = 'Approbateur';
        // $model->
        if ($model->load(\Yii::$app->request->post())) {


            $model->role_id = $id;
            if ($model->save()) {
            } else {
                throw new NotFoundHttpException(403, \Yii::t('app', 'Vous pouvez pas faire cette modification de grade'));
            }
            return $this->redirect(['/grade/view', 'id' => $model->id]);
        }

        return $this->render('/user/admin/grade/update', [
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

        return $this->redirect(['/grade']);
    }
    /**
     * Displays a single Grade model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('/user/admin/grade/view', [
            'model' => $this->findModel($id),
        ]);
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
