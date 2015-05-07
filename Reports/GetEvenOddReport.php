<?php
/**
 * Copyright (C) Piwik PRO - All rights reserved.
 *
 * Using this code requires that you first get a license from Piwik PRO.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 * @link http://piwik.pro
 */

namespace Piwik\Plugins\VisitHoursEvenOdd\Reports;

use Piwik\Piwik;
use Piwik\Plugin\Report;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\VisitTime\Columns\LocalTime;

use Piwik\View;

/**
 * This class defines a new report.
 *
 * See {@link http://developer.piwik.org/api-reference/Piwik/Plugin/Report} for more information.
 */
class GetEvenOddReport extends Base
{
    protected function init()
    {
        parent::init();

        $this->name          = Piwik::translate('VisitHoursEvenOdd_EvenOddReport');
        $this->dimension     = null;
        $this->documentation = Piwik::translate('');
        $this->dimension     = new LocalTime();

        // This defines in which order your report appears in the mobile app, in the menu and in the list of widgets
        $this->order = 1;

        // By default standard metrics are defined but you can customize them by defining an array of metric names
        $this->metrics       = array('nb_visits');

        // Uncomment the next line if your report does not contain any processed metrics, otherwise default
        // processed metrics will be assigned
        // $this->processedMetrics = array();

        // Uncomment the next line if your report defines goal metrics
        // $this->hasGoalMetrics = true;

        // Uncomment the next line if your report should be able to load subtables. You can define any action here
        // $this->actionToLoadSubTables = $this->action;

        // Uncomment the next line if your report always returns a constant count of rows, for instance always
        // 24 rows for 1-24hours
        // $this->constantRowsCount = true;

        // If a menu title is specified, the report will be displayed in the menu
        $this->menuTitle    = 'VisitHoursEvenOdd_EvenOddReport';

        // If a widget title is specified, the report will be displayed in the list of widgets and the report can be
        // exported as a widget
        $this->widgetTitle  = 'VisitHoursEvenOdd_EvenOddReport';
    }

    /**
     *
     * @param ViewDataTable $view
     */
    public function configureView(ViewDataTable $view)
    {
        if (!empty($this->dimension)) {
            $view->config->addTranslations(array('label' => $this->dimension->getName()));
        }

        $view->config->show_search = false;
        // $view->requestConfig->filter_sort_column = 'nb_visits';
        // $view->requestConfig->filter_limit = 10';

        $view->config->addTranslation('label', Piwik::translate('VisitHoursEvenOdd_VisitHours'));

        $view->config->columns_to_display = array_merge(array('label'), array('nb_visits'));
    }
}
