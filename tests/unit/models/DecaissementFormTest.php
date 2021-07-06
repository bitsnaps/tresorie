<?php

namespace tests\unit\models;

use app\models\Decaissement;
use yii\mail\MessageInterface;
use app\tests\unit\fixtures\UserFixture;

class DecaissementFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    // Fixtures are needed here
    public function _fixtures()
    {
      return [
        'users' => [
          'class' => UserFixture::class,
        ]
      ];
    }

    public function _before()
    {
    }

    public function _after()
    {
    }

    public function testDecaissementIsSentOnUserDemande()
    {
        $user1 = $this->tester->grabFixture('users','user1');
        //models intialization
        $model = new Decaissement();
        $model->attributes = [
            'montant' => 2000,
            'motif' => 'Dinner',
            'sender_user_id'=>1,
            'approved_by'=>1
        ];

        $this->assertEquals($model->save(),true);
        $this->assertEquals($user1->username, 'admin');
    }
}
