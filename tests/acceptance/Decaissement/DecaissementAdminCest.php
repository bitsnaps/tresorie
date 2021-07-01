<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class DecaissementAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=user%2Fsecurity%2Flogin');
        $I->fillField('#loginform-login', 'admin');
        $I->fillField('#loginform-password', '1234567');
        $I->click('Sign in');
        $I->wait(2); // wait for button to be clicked
        $I->saveSessionSnapshot('login');
    }
    

    public function viewAllDecaissement(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin%2Fdecaissement');
            $I->click('Tous les Décaissements');
            $I->wait(5); // wait for button to be clicked
            // $I->expectTo('see user info');
            // $I->see('Logout');
        }
    }

    public function confirmDecaissement(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin%2Fdecaissement');
            $I->click('Tous les Décaissements');
         
            $I->wait(5); // wait for button to be clicked
            $I->click('Confirmer');
            $I->click('Ok');
            $I->wait(5); // wait for button to be clicked
            // $I->expectTo('see user info');
            // $I->see('Logout');
        }
        
       
    }
   /* public function BlockDecaissement(AcceptanceTester $I)
    {
          //check if at list exist one decaissement
    }*/
}
