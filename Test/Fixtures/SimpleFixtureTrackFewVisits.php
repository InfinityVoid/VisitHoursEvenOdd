<?php
/**
 * Copyright (C) Piwik PRO - All rights reserved.
 *
 * Using this code requires that you first get a license from Piwik PRO.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 * @link http://piwik.pro
 */
namespace Piwik\Plugins\VisitHoursEvenOdd\Test\Fixtures;

use Piwik\Date;
use Piwik\Tests\Framework\Fixture;

/**
 * Generates tracker testing data for our ApiReturnsTest
 *
 * This Simple fixture adds one website and tracks one visit with couple pageviews and an ecommerce conversion
 */
class SimpleFixtureTrackFewVisits extends Fixture
{
    public $dateTime = '2013-01-23 01:00:00';
    public $idSite = 1;

    public function setUp()
    {
        $this->setUpWebsite();
        $this->trackSomeVisits();
    }

    public function tearDown()
    {
        // empty
    }

    private function setUpWebsite()
    {
        if (!self::siteCreated($this->idSite)) {
            $idSite = self::createWebsite($this->dateTime, $ecommerce = 1);
            $this->assertSame($this->idSite, $idSite);
        }
    }

    protected function trackSomeVisits()
    {
        $t = self::getTracker($this->idSite, $this->dateTime, $defaultInit = true);

        for ($i=0; $i<15; $i++) {
            $t->setForceNewVisit();
            echo Date::factory($this->dateTime)->addHour($i*1)->getDatetime()."\n";
            $t->setForceVisitDateTime(Date::factory($this->dateTime)->addHour($i*1)->getDatetime());
            $t->setUrl('http://example.com/');
            $response = $t->doTrackPageView('Viewing homepage');
            var_dump($response);
            self::checkResponse($response);
        }
    }
}