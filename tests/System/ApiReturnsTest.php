<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\VisitHoursEvenOdd\tests\System;

use Piwik\Plugins\VisitHoursEvenOdd\tests\fixtures\SimpleFixtureTrackFewVisits;
use Piwik\Tests\Framework\TestCase\SystemTestCase;

/**
 * @group VisitHoursEvenOdd
 * @group ApiReturnsTest
 * @group Plugins
 */
class ApiReturnsTest extends SystemTestCase
{
    /**
     * @var SimpleFixtureTrackFewVisits
     */
    public static $fixture = null; // initialized below class definition

    /**
     * @dataProvider getApiForTesting
     */
    public function testApi($api, $params){
        $this->runApiTests($api, $params);
    }

    public function getApiForTesting(){

        $idSite = self::$fixture->idSite;
        $dateTime = self::$fixture->dateTime;

        $apiToTest = array(
            array(
                'Api.getEvenOddReport',
                array(
                    'idSite'     => $idSite,
                    'date'       => $dateTime,
                )
            )
        );

        return $apiToTest;
    }

    public static function getOutputPrefix(){
        return '';
    }

    public static function getPathToTestDirectory(){
        return dirname(__FILE__);
    }

}

ApiReturnsTest::$fixture = new SimpleFixtureTrackFewVisits();
