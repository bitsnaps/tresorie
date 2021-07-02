<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace app\controllers\user;



use app\models\User;
use app\models\AuthAssignment;
use Da\User\Event\UserEvent;
use Da\User\Factory\MailFactory;
use Da\User\Filter\AccessRuleFilter;
use Da\User\Model\Profile;

use Da\User\Query\UserQuery;
use Da\User\Search\UserSearch;
use Da\User\Service\PasswordRecoveryService;
use Da\User\Service\SwitchIdentityService;
use Da\User\Service\UserBlockService;
use Da\User\Service\UserConfirmationService;
use Da\User\Service\UserCreateService;
use Da\User\Traits\ContainerAwareTrait;
use Da\User\Validator\AjaxRequestModelValidator;
use Yii;
use yii\base\Module;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use Da\User\Controller\AdminController as BaseController;
;
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
                ],
            ],
        ];
    }
    public function actionConfirm($id)
    {
        /** @var User $user */
        $user = $this->userQuery->where(['id' => $id])->one();
        /** @var UserEvent $event */
        $event = $this->make(UserEvent::class, [$user]);

        $this->trigger(UserEvent::EVENT_BEFORE_CONFIRMATION, $event);

        if ($this->make(UserConfirmationService::class, [$user])->run()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('usuario', 'User has been confirmed'));
            /**
             * static method for the assignement of responsableDeStation On userConfirmation by an admin
             *@param mixed $user_id
             */
            User::assignRoleToConfirmedUser($user->id);


            $this->trigger(UserEvent::EVENT_AFTER_CONFIRMATION, $event);
        } else {
            Yii::$app->getSession()->setFlash(
                'warning',
                Yii::t('usuario', 'Unable to confirm user. Please, try again.')
            );
        }

        return $this->redirect(Url::previous('actions-redirect'));
    }


    /**
     * @parms   
     */
    public function actionBlock($id)
    {
        if ((int)$id === Yii::$app->user->getId()) {
            Yii::$app->getSession()->setFlash('danger', Yii::t('usuario', 'You cannot remove your own account'));
        } else {
            /** @var User $user */
            $user = $this->userQuery->where(['id' => $id])->one();
            /** @var UserEvent $event */
            $event = $this->make(UserEvent::class, [$user]);

            if ($this->make(UserBlockService::class, [$user, $event, $this])->run()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('usuario', 'User block status has been updated.'));
            } else {
                Yii::$app->getSession()->setFlash('danger', Yii::t('usuario', 'Unable to update block status.'));
            }
        }

        return $this->redirect(Url::previous('actions-redirect'));
    }
    /**
     * This function is used for the creation of a user and assignment of role to it
     *
     * @return void
     */
    public function actionCreate()
    {
        /** @var User $user */
        $user = $this->make(User::class, [], ['scenario' => 'create']);

        /** @var UserEvent $event */
        $event = $this->make(UserEvent::class, [$user]);

        $this->make(AjaxRequestModelValidator::class, [$user])->validate();

        if ($user->load(Yii::$app->request->post())) {
            $this->trigger(UserEvent::EVENT_BEFORE_CREATE, $event);

            $mailService = MailFactory::makeWelcomeMailerService($user);

            if ($this->make(UserCreateService::class, [$user, $mailService])->run()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('usuario', 'User has been created'));
                $this->trigger(UserEvent::EVENT_AFTER_CREATE, $event);
                $role_name=$user->role;
             //   var_dump($user->Role);
               
                User::assignRoleToConfirmedUser($user->id,$role_name);
                Yii::$app->session->setFlash('success', Yii::t('usuario', 'Vous avez crée un nouvelle utilisateur avec le role '.$role_name));
                return $this->redirect(['create', 'id' => $user->id]);
            }
            Yii::$app->session->setFlash('danger', Yii::t('usuario', 'User account could not be created.'));
        }

        return $this->render('create', ['user' => $user]);
    }
 /**
  *  Overide action Update
  *
  * @param [type] $id
  * @return void
  */
    public function actionUpdate($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        $user->setScenario('update');
        /** @var UserEvent $event */
        $event = $this->make(UserEvent::class, [$user]);

        $this->make(AjaxRequestModelValidator::class, [$user])->validate();

        if ($user->load(Yii::$app->request->post())) {
            $this->trigger(ActiveRecord::EVENT_BEFORE_UPDATE, $event);

            if ($user->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('usuario', 'Account details have been updated'));
                $this->trigger(ActiveRecord::EVENT_AFTER_UPDATE, $event);

                return $this->refresh();
            }
        }

        return $this->render('_account', ['user' => $user]);
    }
}
