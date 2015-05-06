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


class Archiver extends \Piwik\Plugin\Archiver
{
    const HOURS_EVEN_ODD_RECORD_NAME = 'VisitHoursEvenOdd_evenOddVisitHours';

    public function aggregateDayReport()
    {
        $array = $this->getLogAggregator()->getMetricsFromVisitByDimension("MOD(HOUR(log_visit.visitor_localtime),2)");
        $this->ensureBothHoursAreSet($array);
        $report = $array->asDataTable()->getSerialized();
        $this->getProcessor()->insertBlobRecord(self::HOURS_EVEN_ODD_RECORD_NAME, $report);
    }

    public function aggregateMultipleReports()
    {
        $dataTableRecords = array(
            self::HOURS_EVEN_ODD_RECORD_NAME,
        );
        $columnsAggregationOperation = null;
        $this->getProcessor()->aggregateDataTableRecords(
            $dataTableRecords,
            $maximumRowsInDataTableLevelZero = null,
            $maximumRowsInSubDataTable = null,
            $columnToSortByBeforeTruncation = null,
            $columnsAggregationOperation,
            $columnsToRenameAfterAggregation = null,
            $countRowsRecursive = array());
    }

    private function ensureBothHoursAreSet(DataArray &$array)
    {
        $data = $array->getDataArray();
        for ($i = 0; $i <= 1; $i++) {
            if (empty($data[$i])) {
                $array->sumMetricsVisits($i, DataArray::makeEmptyRow());
            }
        }
    }
}