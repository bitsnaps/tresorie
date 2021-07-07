<?php

namespace app\controllers\user;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use Da\User\Form\LoginForm;
use Da\User\Event\FormEvent;
use app\models\User;
use yii\widgets\ActiveForm;
use Da\User\Controller\SecurityController as BaseController;


class UserController extends BaseController
{

    public function actionLogin()
    {

        if (!Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }

        /** @var LoginForm $form */
        $form = $this->make(LoginForm::class);

        /** @var FormEvent $event */
        $event = $this->make(FormEvent::class, [$form]);

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($form);
        }

        if ($form->load(Yii::$app->request->post())) {
            if ($this->module->enableTwoFactorAuthentication && $form->validate()) {
                if ($form->getUser()->auth_tf_enabled) {

                    Yii::$app->session->set('credentials', ['login' => $form->login, 'pwd' => $form->password]);

                    return $this->redirect(['confirm']);
                }
            }

            $this->trigger(FormEvent::EVENT_BEFORE_LOGIN, $event);
            if ($form->login()) {
                $form->getUser()->updateAttributes(['last_login_at' => time()]);

                $this->trigger(FormEvent::EVENT_AFTER_LOGIN, $event);
                //redirecting corresponding the role
                if(User::isAdmin()){
                    Yii::$app->homeUrl="/user/admin";
                    return $this->redirect(['/user/admin']);
                }
                if(User::isAprobateur()){
                    Yii::$app->homeUrl="/decaissement";
                    return $this->redirect(['/decaissement/index']);
                }
                if(User::isResponsableDeStation()){
                    Yii::$app->homeUrl="/decaissement/create";
                    return $this->redirect(['/decaissement/create']);
                }else{
                    throw new \yii\web\NotFoundHttpException(\Yii::t('app', 'Attendez qu\'un admin vous affecte un grade'));
                }

                return $this->goBack();
            }
        }

        return $this->render(
            'login',
            [
                'model' => $form,
                'module' => $this->module,
            ]
        );
    }
    public function actionConfirm()
    {
        if (!Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }

        if (!Yii::$app->session->has('credentials')) {
            return $this->redirect(['login']);
        }

        $credentials = Yii::$app->session->get('credentials');
        /** @var LoginForm $form */
        $form = $this->make(LoginForm::class);
        $form->login = $credentials['login'];
        $form->password = $credentials['pwd'];
        $form->setScenario('2fa');

        /** @var FormEvent $event */
        $event = $this->make(FormEvent::class, [$form]);

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($form);
        }

        if ($form->load(Yii::$app->request->post())) {
            $this->trigger(FormEvent::EVENT_BEFORE_LOGIN, $event);

            if ($form->login()) {
                Yii::$app->session->set('credentials', null);

                $form->getUser()->updateAttributes(['last_login_at' => time()]);

                $this->trigger(FormEvent::EVENT_AFTER_LOGIN, $event);

                return $this->goBack();
            }
        }

        return $this->render(
            'confirm',
            [
                'model' => $form,
                'module' => $this->module,
            ]
        );
    }
}
