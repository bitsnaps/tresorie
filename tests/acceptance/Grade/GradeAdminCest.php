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
            $I->click('Créer');
            $I->click('Nouveau Grade');
            //Filling the creation of new grade
            $option = $I->grabTextFrom('#grade-user_id    option:nth-child(2)');
            $I->selectOption("#grade-user_id ", $option);
            $option = $I->grabTextFrom('#grade-role_id  option:nth-child(2)');
            $I->selectOption("#grade-role_id   ", $option);
            $I->fillField('#grade-niveau', 2);
            $I->fillField('#grade-montant', 1000);
            $I->click('Save');

        }
    }

    public function viewAllGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->click('Grade');
            $I->wait(5); // wait for button to be clicked

        }
    }
  /*  public function viewSpecifiqueGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/Paliers');

        }
    }
    public function UpdateSpecifiqueGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('index.php?r=admin/Paliers');

        }
    }
        public function deleteSpecifiqueGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->amOnPage('admin/Paliers');

        }
    }*/

}
