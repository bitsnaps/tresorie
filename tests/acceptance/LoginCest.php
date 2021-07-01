<?php

use yii\helpers\Url;

class LoginCest
{

    
    public function ensureThatLoginWorksAsUser(AcceptanceTester $I)
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
    public function ensureThatLoginWorksAsAprobateur(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=user%2Fsecurity%2Flogin');
        $I->wait(5); // wait for button to be clicked
        $I->fillField('#loginform-login', 'Aprobateur');
        $I->fillField('#loginform-password', 'Aprobateur');
        $I->click('Sign in');
        $I->wait(5); // wait for button to be clicked

       // $I->expectTo('see user info');
       // $I->see('Logout');
    }
    public function ensureThatLoginWorksAsAdmin(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=user%2Fsecurity%2Flogin');
        $I->wait(5); // wait for button to be clicked
        $I->fillField('#loginform-login', 'Admin');
        $I->fillField('#loginform-password', '1234567');
        $I->click('Sign in');
        $I->wait(5); // wait for button to be clicked

       // $I->expectTo('see user info');
       // $I->see('Logout');
    }
   
}
