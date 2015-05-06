<?php
/**
 * Copyright (C) Piwik PRO - All rights reserved.
 *
 * Using this code requires that you first get a license from Piwik PRO.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 * @link http://piwik.pro
 */
namespace Piwik\Plugins\VisitHoursEvenOdd;

use Piwik\Archive;
use Piwik\Piwik;
use Piwik\DataTable;
use Piwik\DataTable\Row;
use Piwik\API\Request;

/**
 * API for plugin VisitHoursEvenOdd
 *
 * @method static \Piwik\Plugins\VisitHoursEvenOdd\API getInstance()
 */
class API extends \Piwik\Plugin\API
{

    protected function getDataTable($name, $idSite, $period, $date, $segment)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $archive = Archive::build($idSite, $period, $date, $segment);
        $dataTable = $archive->getDataTable($name);

        $dataTable->filter('Sort', array('label', 'asc', true, false));
        $dataTable->queueFilter('ColumnCallbackReplace', array('label', function ($label) {
            switch($label)
            {
                case "0":
                    return Piwik::translate('VisitHoursEvenOdd_EvenOption');
                case "1":
                    return Piwik::translate('VisitHoursEvenOdd_OddOption');
                default:
                    return Piwik::translate('VisitHoursEvenOdd_UnknownError');
            }
        }));
        $dataTable->queueFilter('ReplaceColumnNames');
        return $dataTable;
    }

    /**
     * Method that requests DataTable for even and odd hours report.
     *
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function getEvenOddReport($idSite, $period, $date, $segment = false)
    {
        $table = $this->getDataTable(Archiver::HOURS_EVEN_ODD_RECORD_NAME, $idSite, $period, $date, $segment);
        $table->applyQueuedFilters();
        return $table;
    }
}
