<?php
namespace app\widgets;

use Yii;

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
        
        $html.='
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-blue order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Administrateur</h6>
                            <h2 class="text-right">
                           
                            <span>486</span></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-green order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Aprobateur</h6>
                            <h2 class="text-right">
                         
                            <span>486</span></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-yellow order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Responsable de station</h6>
                            <h2 class="text-right">
                           
                            <span>486</span></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-pink order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Decaissement</h6>
                            <h2 class="text-right">
                           
                            <span>486</span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
        return $html;
         
        
    }
}
