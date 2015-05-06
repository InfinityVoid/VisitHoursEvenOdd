<?php
/**
 * Copyright (C) Piwik PRO - All rights reserved.
 *
 * Using this code requires that you first get a license from Piwik PRO.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 * @link http://piwik.pro
 */

namespace Piwik\Plugins\VisitHoursEvenOdd\Test\Integration;

use Piwik\Date;
use Piwik\Plugins\VisitHoursEvenOdd\Test\Fixtures\SimpleFixtureTrackFewVisits;
use Piwik\Tests\Framework\TestCase\IntegrationTestCase;

/**
 * @group VisitHoursEvenOdd
 * @group VisitHoursEvenOddTest
 * @group Plugins
 */
class VisitHoursEvenOddApiTest extends IntegrationTestCase
{

    /**
     * @var SimpleFixtureTrackFewVisits
     */
    public static $fixture = null; // initialized below class definition

    /**
     * @dataProvider getApiForTesting
     */
    public function testApi($api, $params)
    {
        $this->runApiTests($api, $params);
        die();
    }

    public function getApiForTesting()
    {

        $idSite = '1';
        $date = Date::factory(self::$fixture->dateTime);

        $apiToTest = array(
            array(
                'VisitHoursEvenOdd.getEvenOddReport',
                array(
                    'idSite'     => $idSite,
                    'date'       => $date,
                    'periods' => array('day'),
                )
            )
        );

        return $apiToTest;
    }

    public static function getOutputPrefix()
    {
        return '';
    }

    public static function getPathToTestDirectory()
    {
        return dirname(__FILE__);
    }
}

VisitHoursEvenOddApiTest::$fixture = new SimpleFixtureTrackFewVisits();
