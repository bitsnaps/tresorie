<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class TransactionAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('user/security/login');
        $I->fillField('#loginform-login', 'admin');
        $I->fillField('#loginform-password', '1234567');
        $I->click('Sign in');
        $I->wait(2); // wait for button to be clicked
        $I->saveSessionSnapshot('login');
    }
    

    public function viewAllTransction(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('transaction/index');
            $I->click('Tous les transactions');
    
            // $I->expectTo('see user info');
            // $I->see('Logout');
        }
    }

    public function searchTransaction(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('transaction/index');
        
          
            // $I->expectTo('see user info');
            // $I->see('Logout');
        }
        
       
    }

}
