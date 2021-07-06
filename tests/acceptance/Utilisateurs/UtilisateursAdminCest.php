<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class UtilisateursAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/security/login'));
        $I->fillField('#loginform-login', 'admin');
        $I->fillField('#loginform-password', 'admin123');
        $I->click(['class' => 'btn-primary']);
        try {
          // $I->wait(2); // wait for button to be clicked
        } catch (\Exception $e) {
        }
        $I->saveSessionSnapshot('login');
    }

    public function createNouveauUtilisateur(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->click('Créer');
          //  $I->scrollTo('//a[@href="/some_page.html"]');
          //  $I->click('//a[@href="/some_page.html"]');
            $I->click('Nouvelle utilisateur');
            $I->fillField('#user-email', 'user1@gmail.com');
            $I->fillField('#user-username', 'user1');
            $I->fillField('#user-password', 'user123');
            $option = $I->grabTextFrom('select option:nth-child(3)');
            $I->selectOption("select", $option);
            $I->click('Save');
            try {
              // $I->wait(2); // wait for button to be clicked
            } catch (\Exception $e) {
            }
            // $I->expectTo('see user info');
            $I->see('Logout');
        }
    }

}
