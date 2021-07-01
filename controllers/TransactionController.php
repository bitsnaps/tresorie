<?php

namespace app\controllers;
use app\models\Transaction;
use app\models\TransactionSearch;
use  Da\User\Controller\AdminController as BaseController;

class TransactionController extends BaseController
{
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
