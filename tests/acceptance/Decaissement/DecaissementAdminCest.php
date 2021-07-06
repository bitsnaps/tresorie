<?php

use yii\helpers\Url;
use app\tests\fixtures\UserFixture;

/**
* Those tests concern  user creating and viewing his demandes
 */
class DecaissementAdminCest
{
    // Fixtures are needed here
    public function _fixtures()
    {
      return [
        'users' => [
          'class' => UserFixture::class,
        ]
      ];
    }

    public function _after(\AcceptanceTester $I)
    {
    }

    public function _before(\AcceptanceTester $I)
    {
        $admin = $I->grabFixture('users', 'user1');
        $I->amOnPage(Url::toRoute('/user/security/login'));
        $I->fillField('#loginform-login', $admin->username);
        $I->fillField('#loginform-password', 'admin123');
        $I->click(['class' => 'btn-primary']);
        try {
          // $I->wait(2); // wait for button to be clicked
        } catch (\Exception $e) {
        }
        $I->dontSee('Logout');
        try {
          $I->saveSessionSnapshot('login'); // works only for WebDriver
        } catch (\Exception $e) {}
    }

    public function viewAllDecaissement(\AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage(Url::toRoute('/admin/decaissement'));
            $I->dontSee('Logout');
        }
    }
   /* public function viewAllDecaissement(\AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/decaissement');


            // $I->expectTo('see user info');
            // $I->see('Logout');
        }
    }

    public function confirmDecaissement(\AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/decaissement');
            $I->click('Tous les Décaissements');
            $I->click('Confirmer');
            $I->click('Ok');
            $I->see('Confirmed');
            //$I->wait(2); // wait for button to be clicked
            // $I->see('Logout');
        }


    }
   /* public function BlockDecaissement(\AcceptanceTester $I)
    {
          //check if at list exist one decaissement
    }*/
}
