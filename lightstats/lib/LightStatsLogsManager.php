<?php

/**
 * @copyright (C) 2022, 299Ko
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @author Maxence Cauderlier <mx.koder@gmail.com>
 * 
 * @package 299Ko https://github.com/299Ko/299ko
 */
defined('ROOT') OR exit('No direct script access allowed');

class LightStatsLogsManager {

    public $dateStart;
    public $dateEnd;
    public $logs = [];
    public $uniquesVisitor = [];
    protected $path;
    
    public $datas = [];

    public function __construct($dateStart = false, $dateEnd = false) {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->path = DATA_PLUGIN . 'lightstats/logs/';
        $this->parseLogs();
    }

    protected function parseLogs() {
        $period = new DatePeriod(
                $this->dateStart,
                new DateInterval('P1D'),
                $this->dateEnd
        );

        foreach ($period as $value) {
            $file = $this->path . $value->format('Y/m/d') . '.json';
            $day = $value->format('d/m/Y');
            $dayVisitors = [];
            $this->datas[$day]['pages'] = 0;
            $logs = is_file($file) ? util::readJsonFile($file) : false;
            if ($logs === false) {
                $this->datas[$day]['visitors'] = 0;
                continue;
            }
            foreach ($logs as $k => $log) {
                $this->logs[] = new LightStatsLog($log);
                $this->uniquesVisitor[$log['ip']] = 1;
                $this->datas[$day]['pages']++;
                $dayVisitors[$log['ip']] = 1;
            }
            $this->datas[$day]['visitors'] = count($dayVisitors);
        }
    }
    
    public function hasLogs() {
        return (!empty($this->logs));
    }
    
    public function getChartsDays() {
        $days = [];
        foreach ($this->datas as $k => $v) {
            $days[] = '"' . $k . '"';
        }
        return implode(',', $days);
    }
    
    public function getChartsPages() {
        $pages = [];
        foreach ($this->datas as $v) {
            $pages[] = $v['pages'];
        }
        return implode(',', $pages);
    }
    
    public function getChartsVisitors() {
        $visitors = [];
        foreach ($this->datas as $v) {
            $visitors[] = $v['visitors'];
        }
        return implode(',', $visitors);
    }

}
