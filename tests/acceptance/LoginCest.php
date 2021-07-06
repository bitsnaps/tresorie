<?php

use yii\helpers\Url;
use app\tests\fixtures\UserFixture;

class LoginCest
{

    // Fixtures are needed here
    public function _fixtures()
    {
      return [
        'users' => [
          'class' => UserFixture::class,
        ]
      ];
    }

    public function _before(\AcceptanceTester $I)
    {
        $users = $I->grabFixture('users');
    }

    public function _after(\AcceptanceTester $I)
    {
    }

    public function ensureCreatedUsersMustBeConfirmed(AcceptanceTester $I)
    {
        $admin = $I->grabFixture('users', 'user1');
        $I->amOnPage(Url::toRoute('/user/security/login'));
        $I->see('Login', 'a');
        //$I->wait(5); // wait for button to be clicked
        $I->fillField('#loginform-login', $admin->username);
        $I->fillField('#loginform-password', 'admin123');
        $I->click(['class' => 'btn-primary']);
        try {
          // $I->wait(2); // wait for button to be clicked
        } catch (\Exception $e) {
        }
       // $I->expectTo('see error page 404');
       // $I->dontSee(
       $I->see(
         "Login"
       );
       // $I->click(['class' => 'logout']);
    }

    public function ensureThatLoginWorksAsAprobateur(AcceptanceTester $I)
    {
        $approbateur1 = $I->grabFixture('users', 'user2');
        $I->amOnPage(Url::toRoute('/user/security/login'));
        $I->fillField('#loginform-login', $approbateur1->username);
        $I->fillField('#loginform-password', 'approbateur1');
        $I->click(['class' => 'btn-primary']);
        try {
          // $I->wait(2); // wait for button to be clicked
        } catch (\Exception $e) {
        }
       // $I->expectTo('see error page 404');
       $I->see('Logout');
    }

}
