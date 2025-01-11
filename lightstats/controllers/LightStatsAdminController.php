<?php

/**
 * @copyright (C) 2025, 299Ko
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @author Maxence Cauderlier <mx.koder@gmail.com>
 * 
 * @package 299Ko https://github.com/299Ko/299ko
 */
defined('ROOT') or exit('No direct script access allowed');

class LightStatsAdminController extends AdminController
{
    public function home() {
        require_once PLUGINS . 'lightstats/lib/UserAgent/UserAgentInterface.php';
        require_once PLUGINS . 'lightstats/lib/UserAgent/Browsers.php';
        require_once PLUGINS . 'lightstats/lib/UserAgent/Platforms.php';
        require_once PLUGINS . 'lightstats/lib/UserAgent/UserAgent.php';
        require_once PLUGINS . 'lightstats/lib/UserAgent/UserAgentParser.php';
        require_once PLUGINS . 'lightstats/lib/UserAgentParser.php';

        require_once PLUGINS . 'lightstats/lib/LightStatsLogsManager.php';
        require_once PLUGINS . 'lightstats/lib/LightStatsLog.php';

        $dateStart = isset($_POST['dateStart']) ? new DateTime($_POST['dateStart']) : new DateTime();
        $dateEnd = isset($_POST['dateEnd']) ? new DateTime($_POST['dateEnd']) : new DateTime();

        // Dates for select date form
        $browserDateStart = $dateStart->format('Y-m-d');
        $browserDateEnd = $dateEnd->format('Y-m-d');

        // Dates for human readable
        $inDateStart = util::getDate($dateStart->getTimestamp());
        $inDateEnd = util::getDate($dateEnd->getTimestamp());

        $dateEnd->modify('+1 day');

        $logsManager = new LightStatsLogsManager($dateStart, $dateEnd);
        $logs = $logsManager->logs;
        $uniqueVisitor = $logsManager->uniquesVisitor;

        $chartVisitors = $logsManager->getChartsVisitors();
        $chartPages = $logsManager->getChartsPages();
        $chartDays = $logsManager->getChartsDays();
        $response = new AdminResponse();
        $tpl = $response->createPluginTemplate('lightstats', 'admin');
        $tpl->set('linkToHome', $this->router->generate('admin-lightstats-home'));
        $tpl->set('browserDateStart', $browserDateStart);
        $tpl->set('browserDateEnd', $browserDateEnd);
        $tpl->set('inDateStart', $inDateStart);
        $tpl->set('inDateEnd', $inDateEnd);
        $tpl->set('logsManager', $logsManager);
        $tpl->set('logs', $logs);
        $tpl->set('uniqueVisitor', $uniqueVisitor);
        $tpl->set('chartVisitors', $chartVisitors);
        $tpl->set('chartPages', $chartPages);
        $tpl->set('chartDays', $chartDays);
        $response->addTemplate($tpl);
        return $response;
    }
}