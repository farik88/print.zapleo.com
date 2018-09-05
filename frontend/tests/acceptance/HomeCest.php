<?php
namespace frontend\tests\acceptance;

use Yii;
use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('Выберите свой');
//        $I->seeLink('About');
//        $I->click('About');
//        $I->see('This is the About page.');
    }

    public function checkClick(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        //$I->see('');
        $I->seeLink('.goToo');
        $I->click('.goToo');
        $I->see('Дизайн');
    }
}
