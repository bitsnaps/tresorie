<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class DecaissementAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('index-test.php?ruser/security/login');
        $I->fillField('#loginform-login', 'admin');
        $I->fillField('#loginform-password', '1234567');
        $I->click('Sign in');
        $I->wait(6); // wait for button to be clicked
        $I->saveSessionSnapshot('login');
    }
    
    public function viewAllDecaissement(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index-test.php?r=admin/decaissement');
        }
    }
   /* public function viewAllDecaissement(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/decaissement');
     
    
            // $I->expectTo('see user info');
            // $I->see('Logout');
        }
    }

    public function confirmDecaissement(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/decaissement');
            $I->click('Tous les Décaissements');
            $I->click('Confirmer');
            $I->click('Ok');
            $I->see('Confirmed');
            $I->wait(10); // wait for button to be clicked
            // $I->see('Logout');
        }
        
       
    }
   /* public function BlockDecaissement(AcceptanceTester $I)
    {
          //check if at list exist one decaissement
    }*/
}
