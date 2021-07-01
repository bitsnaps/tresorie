<?php

namespace tests\unit\models;

use app\models\Decaissement;
use yii\mail\MessageInterface;

class DecaissementFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testDecaissementIsSentOnUserDemande()
    {
        //models intialization
        $model = new Decaissement();
        $model->attributes = [
            'montant' => 2000,
            'motif' => 'Dinner',
            'sender_user_id'=>1
           
        ];

        $this->assertEquals($model->save(),true);

       
    }
}
