<?php

/** @var Scenario $scenario */

use Codeception\Scenario;

$I = new AcceptanceTester($scenario);
$I->wantTo('Check if index page displayed, pagination is working and and CSV file available for download');
$I->amOnPage('/');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Americor Test');
$I->see('Task created: Follow up');

for ($i = 1; $i <=31; $i++) {
    $I->click((string)$i);
    $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

}

$I->click('CSV');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
