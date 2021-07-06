<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class DecaissementUserCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/security/login'));
        $I->fillField('#loginform-login', 'Utilisateur');
        $I->fillField('#loginform-password', '1234567');
        $I->click('Sign in');
        try {
          // $I->wait(2); // wait for button to be clicked
        } catch (\Exception $e) {
        }
        try {
          $I->saveSessionSnapshot('login'); // works only for WebDriver
        } catch (\Exception $e) {}
    }


    public function createDecaissementSansFichierJointe(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
             // $I->amOnPage('index.php?r=responsable-de-station%2Fcreate-demande');
            $I->fillField('#decaissement-montant', 2000);
            $I->fillField('#decaissement-motif', 'dinner');
            $I->click('Save');

            try {
              // $I->wait(2); // wait for button to be clicked
            } catch (\Exception $e) {
            }
        }

       // $I->see('Logout');
    }

    public function viewAllDecaissement(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=responsable-de-station/decaissement');
            $I->click('Mes Décaissements');
            try {
              // $I->wait(2); // wait for button to be clicked
            } catch (\Exception $e) {
            }

            // $I->expectTo('see user info');
            // $I->see('Logout');
        }
    }
}
