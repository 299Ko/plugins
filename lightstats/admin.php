<?php

/**
 * @copyright (C) 2022, 299Ko
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @author Maxence Cauderlier <mx.koder@gmail.com>
 * 
 * @package 299Ko https://github.com/299Ko/299ko
 */
defined('ROOT') OR exit('No direct script access allowed');

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

$inDateStart = $dateStart->format('Y-m-d');
$inDateEnd = $dateEnd->format('Y-m-d');

$dateEnd->modify('+1 day');

$logsManager = new LightStatsLogsManager($dateStart, $dateEnd);
$logs = $logsManager->logs;
$uniqueVisitor = $logsManager->uniquesVisitor;

$chartVisitors = $logsManager->getChartsVisitors();
$chartPages = $logsManager->getChartsPages();
$chartDays = $logsManager->getChartsDays();