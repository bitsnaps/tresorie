<?php

use yii\helpers\Url;

class LoginCest
{

    
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=user%2Fsecurity%2Flogin');
        $I->wait(5); // wait for button to be clicked
        $I->fillField('#loginform-login', 'admin');
        $I->fillField('#loginform-password', 'amar500G');
        $I->click('Sign in');
        $I->wait(5); // wait for button to be clicked

       // $I->expectTo('see user info');
       // $I->see('Logout');
    }
    public function waiting(AcceptanceTester $I)
    {

        $I->wait(5); // wait for button to be clicked

       // $I->expectTo('see user info');
       // $I->see('Logout');
    }
}
