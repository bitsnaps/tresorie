<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class DecaissementUserCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=user%2Fsecurity%2Flogin');
        $I->fillField('#loginform-login', 'user');
        $I->fillField('#loginform-password', 'user123');
        $I->click('Sign in');
        $I->wait(2); // wait for button to be clicked
        $I->saveSessionSnapshot('login');
    }
    

    public function createDecaissementSansFichierJointe(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
             // $I->amOnPage('index.php?r=responsable-de-station%2Fcreate-demande');
            $I->fillField('#decaissement-montant', 2000);
            $I->fillField('#decaissement-motif', 'dinner');
            $I->click('Save');
        
            $I->wait(2); // wait for button to be clicked
        }
      
       // $I->see('Logout');
    }

    public function viewAllDecaissement(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=responsable-de-station%2Fdecaissement');
            $I->click('Mes Décaissements');
            $I->wait(5); // wait for button to be clicked
            // $I->expectTo('see user info');
            // $I->see('Logout');
        }
    }
}
