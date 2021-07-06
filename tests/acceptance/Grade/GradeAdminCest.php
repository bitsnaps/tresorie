<?php

use yii\helpers\Url;
/**
* Those tests concern  user creating and viewing his demandes
 */
class GradeAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/security/login'));
        $I->fillField('#loginform-login', 'admin'); // should be retreived from UserFixture
        $I->fillField('#loginform-password', 'admin123');
        $I->click(['class' => 'btn-primary']);
        try {
          // $I->wait(2); // wait for button to be clicked
          $I->saveSessionSnapshot('login');
        } catch (\Exception $e) {
        }

    }

    // TODO: to be reviewed
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

    // TODO: to be reviewed
    public function viewAllGrade(AcceptanceTester $I)
    {
        if ($I->loadSessionSnapshot('login')){
            $I->click('Grade');
            try {
              // $I->wait(2); // wait for button to be clicked
            } catch (\Exception $e) {
            }
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
