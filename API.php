<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\VisitHoursEvenOdd;

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

    /**
     * Another example method that returns a data table.
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function getEvenOddReport($idSite, $period, $date, $segment = false)
    {
        $data = \Piwik\API\Request::processRequest('VisitTime.getVisitInformationPerLocalTime', array(
            'idSite' => $idSite,
            'period' => $period,
            'date' => $date,
            'segment' => $segment
        ));
        $data->applyQueuedFilters();

        $result = $data->getEmptyClone($keepFilters = false);

        foreach ($data->getRows() as $visitRow) {
            $hour = (int) substr($visitRow->getColumn('label'),0,-1);

            if(is_int($hour)){
                $type = ($hour % 2 === 0 ? "Even" : "Odd");
                $resultRow = $result->getRowFromLabel($type);

                if($resultRow === false){
                    $result->addRowFromSimpleArray(array(
                        'label'     => Piwik::translate($type),
                        'nb_visits' => $visitRow->getColumn('nb_visits')
                    ));
                }else{
                    $soFar = $resultRow->getColumn('nb_visits');
                    $resultRow->setColumn('nb_visits', $soFar + $visitRow->getColumn('nb_visits'));
                }
            }
        }

        return $result;
    }
}
