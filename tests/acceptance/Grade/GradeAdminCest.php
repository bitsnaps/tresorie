<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class GradeAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=user/security/login');
        $I->fillField('#loginform-login', 'admin');
        $I->fillField('#loginform-password', '1234567');
        $I->click('Sign in');
        $I->wait(2); // wait for button to be clicked
        $I->saveSessionSnapshot('login');
    }
    public function createNewGrade(AcceptanceTester $I){
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/create-pallier');
            $option = $I->grabTextFrom('select option:nth-child(2)');
            $I->selectOption("select", $option);
            $option = $I->grabTextFrom('select option:nth-child(2)');
            $I->selectOption("select", $option);


        }
    }

    public function viewAllGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('admin/palliers');

        }
    }
    public function viewSpecifiqueGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/palliers');

        }
    }
    public function UpdateSpecifiqueGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/palliers');

        }
    }
        public function deleteSpecifiqueGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('admin/palliers');

        }
    }

}
