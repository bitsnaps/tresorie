<?php
namespace app\widgets;

use Yii;
use app\models\User;
use app\Query\kpiQuery;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Kpi extends \yii\bootstrap\Widget
{



    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $html='';
        if( User::isAdmin())
        $html.='
    
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-blue order-card">
                        <div class="card-block">
                            <h4 class="m-b-20">Administrateur</h4>
                            <h2 class="text-right">
                           
                            <span>'.kpiQuery::countUserByRole('Administrateur').'</span></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-green order-card">
                        <div class="card-block">
                            <h4 class="m-b-20">Approbateur</h4>
                            <h2 class="text-right">
                         
                            <span>'.kpiQuery::countUserByRole('Approbateur').'</span></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-yellow order-card">
                        <div class="card-block">
                            <h4 class="m-b-20">Responsable de station</h4>
                            <h2 class="text-right">
                           
                            <span>'.kpiQuery::countUserByRole('Utilisateur').'</span></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-pink order-card">
                        <div class="card-block">
                            <h4 class="m-b-20">Decaissement</h4>
                            <h2 class="text-right">
                           
                            <span>'.kpiQuery::countDecaissement().'</span></h2>
                        </div>
                    </div>
                </div>
            </div>
       
        ';
        return $html;
         
        
    }
}
