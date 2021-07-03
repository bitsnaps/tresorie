<?php

namespace app\controllers;

use Yii;
use webzop\notifications\Notification;

class AccountNotification extends Notification
{
    const KEY_NEW_ACCOUNT = 'new_account';

    const KEY_RESET_PASSWORD = 'reset_password';

    const KEY_DEMAMDE_DECAISEMENT = 'Décaissement';
    /**
     * @param mixed $name
     * parameter that will be use as parametre for the creation of our notification
     */

    public $user_id ;

    public $username ;

    public $decaissement_id;

    public $decaissement_montant;

    public $decaissement_motif;

    /**
     * @var \yii\web\User the user object
     */
    public $user;
    

    /**
     * @inheritdoc
     */
    public function getTitle($decaissement_motif=null,$decaissement_montant=null,$username=null){
        switch($this->key){
            case self::KEY_NEW_ACCOUNT:
                return Yii::t('app', 'New account {user} created', ['user' => '#'.$this->user->id]);
            case self::KEY_RESET_PASSWORD:
                return Yii::t('app', 'Instructions to reset the password');
            case self::KEY_DEMAMDE_DECAISEMENT:
                return Yii::t('app', 'Responsable de station : '.$username." a demander:  ".$decaissement_montant." DZD "." pour: ".$decaissement_motif );

        }
    }

    /**
     * @inheritdoc
     */
    public function getRoute(){
        return ['/users/edit', 'id' => $this->user->id];
    }
}