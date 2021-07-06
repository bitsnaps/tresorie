<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class TransactionAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/security/login'));
        $I->fillField('#loginform-login', 'admin'); // should be retreived from UserFixture
        $I->fillField('#loginform-password', 'admin123');
        $I->click(['class' => 'btn-primary']);
        try {
          // $I->wait(2); // wait for button to be clicked
        } catch (\Exception $e) {
        }
        $I->saveSessionSnapshot('login');
    }


    public function viewAllTransction(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->click('Tous les transactions');

            // $I->expectTo('see user info');
            $I->see('Logout');
        }
    }

   /* public function searchTransaction(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->click('Tous les transactions');


            // $I->expectTo('see user info');
            // $I->see('Logout');
        }


    }*/

}
