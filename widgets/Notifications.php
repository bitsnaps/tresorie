<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\db\Query;
use webzop\notifications\NotificationsAsset;


class Notifications extends \yii\base\Widget
{

    public $options = ['class' => 'dropdown nav-notifications'];

    /**
     * @var string the HTML options for the item count tag. Key 'tag' might be used here for the tag name specification.
     * For example:
     *
     * ```php
     * [
     *     'tag' => 'span',
     *     'class' => 'badge badge-warning',
     * ]
     * ```
     */
    public $countOptions = [];

    /**
     * @var array additional options to be passed to the notification library.
     * Please refer to the plugin project page for available options.
     */
    public $clientOptions = [];
    /**
     * @var integer the XHR timeout in milliseconds
     */
    public $xhrTimeout = 1000;
    /**
     * @var integer The delay between pulls in milliseconds
     */
    public $pollInterval = 1000;

    public function init()
    {
        parent::init();

        if(!isset($this->options['id'])){
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if(\app\models\User::isAdmin() or \app\models\User::isAprobateur() ){
            echo $this->renderNavbarItem();

            $this->registerAssets();
        }
       
    }

    /**
     * @inheritdoc
     */
    protected function renderNavbarItem()
    {
        $html  = Html::beginTag('li', $this->options);
        $html .= Html::beginTag('a', ['href' => '#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']);
        $html .= Html::tag('span', '', ['class' => 'glyphicon glyphicon-bell']);

        $count = self::getCountUnseen();
        $countOptions = array_merge([
            'tag' => 'span',
            'data-count' => $count,
        ], $this->countOptions);
        Html::addCssClass($countOptions, 'label label-warning navbar-badge notifications-count');
        if(!$count){
            $countOptions['style'] = 'display: none;';
        }
        $countTag = ArrayHelper::remove($countOptions, 'tag', 'span');
        $html .= Html::tag($countTag, $count, $countOptions);

        $html .= Html::endTag('a');
        $html .= Html::begintag('div', ['class' => 'dropdown-menu']);
        $header = Html::a(Yii::t('modules/notifications', 'Mark all as read'), '#', ['class' => 'read-all pull-right']);
        $header .= Yii::t('modules/notifications', 'Notifications');
        $html .= Html::tag('div', $header, ['class' => 'header']);

        $html .= Html::begintag('div', ['class' => 'notifications-list']);
        //$html .= Html::tag('div', '<span class="ajax-loader"></span>', ['class' => 'loading-row']);
        $html .= Html::tag('div', Html::tag('span', Yii::t('modules/notifications', 'There are no notifications to show'), ['style' => 'display: none;']), ['class' => 'empty-row']);
        $html .= Html::endTag('div');

        $footer = Html::a(Yii::t('modules/notifications', 'View all'), ['/notifications/default/index']);
        $html .= Html::tag('div', $footer, ['class' => 'footer']);
        $html .= Html::endTag('div');
        $html .= Html::endTag('li');

        return $html;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $this->clientOptions = array_merge([
            'id' => $this->options['id'],
            'url' => Url::to(['/notifications/default/list']),
            'countUrl' => Url::to(['/notifications/default/count']),
            'readUrl' => Url::to(['/notifications/default/read']),
            'readAllUrl' => Url::to(['/notifications/default/read-all']),
            'xhrTimeout' => Html::encode($this->xhrTimeout),
            'pollInterval' => Html::encode($this->pollInterval),
        ], $this->clientOptions);

        $js = 'Notifications(' . Json::encode($this->clientOptions) . ');';
        $view = $this->getView();

        NotificationsAsset::register($view);

        $view->registerJs($js);
    }

    public static function getCountUnseen(){

        $userId = Yii::$app->getUser()->getId();

        //check if admin
        if(\app\models\User::isAdmin(\app\models\User::getCurrentUser()->id)){

                $count = (new Query())
                ->from('{{%notifications}}')
            //    ->andWhere(['or', 'user_id = 0', 'user_id = :user_id'], [':user_id' => $userId])
                ->andWhere(['seen' => false])
                ->count();
                return $count;
            }else{

                //All aprobateur that have the pallier to aprove
                if(\app\models\User::isAprobateur(\app\models\User::getCurrentUser()->id)){
                    $count = (new Query())
                    ->from('{{%notifications}}')
                    ->innerJoin('decaissementhistorique', 'decaissementhistorique.id = notifications.decaissementhistorique_id')
                    ->innerJoin('grade', 'grade.user_id = decaissementhistorique.reciever_user_id')
                    ->andWhere(['>=','grade.montant','decaissementhistorique.montant'])
                //    ->andWhere(['or', 'user_id = 0', 'user_id = :user_id'], [':user_id' => $userId])
                    ->andWhere(['seen' => false])
                    ->count();
                    
                    return $count;
                }

            }
           
          

    }

}
