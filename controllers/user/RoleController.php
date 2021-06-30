<?php
/**
 * @author ammar <amardjebabla10@gmail.com>
 * In this Controller we will enhance the creation of role
 */
namespace app\controllers\user;
use Yii;
use Da\User\Model\AbstractAuthItem;
use Da\User\Controller\RoleController as BaseController;
use app\models\AuthItem;

class RoleController extends BaseController
{

    public function actionCreate()
    {
        /** @var AbstractAuthItem $model */
        $model = $this->make($this->getModelClass(), [], ['scenario' => 'create']);
        $authItem=new AuthItem();
        

        if ($model->load(Yii::$app->request->post())) {
            $authItem->name=$model->name;
            $authItem->description=$model->description;
            $authItem->type=1;
            if($authItem->save()){
                Yii::$app->session->setFlash('success', 'Role a éte crée avec success.');

            }else{
                print_r($authItem->errors);
                die();
            }
            ;
           
        }

        return $this->render(
            'create',
            [
                'model' => $model,
                'unassignedItems' => $this->authHelper->getUnassignedItems($model),
            ]
        );
    }

}
