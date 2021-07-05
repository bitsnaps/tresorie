<?php

namespace app\controllers\channels;

use Yii;
use webzop\notifications\channels\ScreenChannel as base;
use webzop\notifications\Channel;
use webzop\notifications\Notification;
use app\models\Grade;
class ScreenChannel extends base
{
    public function send(Notification $notification)
    {
        $db = Yii::$app->getDb();
        $className = $notification->className();
        $currTime = time();
        //Our Params
        //$model=Grade::find(['user_id'])->
        $decaissement_id=$notification->decaissement_id;
        $decaissement_motif=$notification->decaissement_motif;
        $decaissement_montant=$notification->decaissement_montant;
        $username=$notification->username;
        //Our Query For the creation of our notification
      
        $db->createCommand()->insert('{{%notifications}}', [
            'class' => strtolower(substr($className, strrpos($className, '\\')+1, -12)),
            'key' => $notification->key,
            'message' => (string)$notification->getTitle($decaissement_motif,$decaissement_montant,$username),
            'route' => serialize($notification->getRoute()),
            'user_id' =>$notification->user->id,
            'decaissementhistorique_id'=>(integer) $notification->decaissement_id,
            'created_at' => $currTime,
        ])->execute();
    
    }

}
