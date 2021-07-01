<?php

use yii\helpers\Url;

class PallierCest
{

    
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=user%2Fsecurity%2Flogin');
        $I->wait(5); // wait for button to be clicked
        $I->fillField('#loginform-login', 'user');
        $I->fillField('#loginform-password', 'user123');
        $I->click('Sign in');
        $I->wait(5); // wait for button to be clicked

       // $I->expectTo('see user info');
       // $I->see('Logout');
    }
    public function createDecaissementSansFichierJointe(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=responsable-de-station%2Fcreate-demande');
        $I->wait(5); // wait for button to be clicked
        $I->fillField('#decaissement-montant', 'user');
        $I->fillField('#decaissement-motif', 'user123');
        $I->click('Save');
        $I->wait(5); // wait for button to be clicked

        $I->expectTo('Votre demande a éte crée avec success');
       // $I->see('Logout');
    }
    public function viewAllDecaissement(AcceptanceTester $I)
    {

        $I->amOnPage('index.php?r=responsable-de-station%2Fcreate-demande');
        $I->click('Mes Décaissements');
        $I->wait(5); // wait for button to be clicked
       // $I->expectTo('see user info');
       // $I->see('Logout');
    }
}
