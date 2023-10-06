<?php

/**
 * @copyright (C) 2022, 299Ko
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @author Maxence Cauderlier <mx.koder@gmail.com>
 * 
 * @package 299Ko https://github.com/299Ko/299ko
 */
defined('ROOT') OR exit('No direct script access allowed');

use donatj\UserAgent\UserAgentParser;

class LightStatsLog {
    
    protected $log;
    
    protected $parser;
    
    protected $ua;
    
    public $ip;
    public $page;
    public $referer;
    public $date;
    public $platform;
    public $browser;
    public $browserVersion;
    public $isBot;

    public function __construct($log) {
        $this->log = $log;
        $this->parser = new UserAgentParser();
        $this->loadInfos();
    }
    
    protected function loadInfos() {
        $this->ua = $this->parser->parse($this->log['userAgent']);
        $this->platform = $this->ua->platform();
        $this->browser = $this->ua->browser();
        $this->browserVersion = $this->ua->browserVersion();
        
        $this->ip = $this->log['ip'];
        $this->page = $this->log['page'];
        $this->referer = $this->log['referer'];
        $this->date = $this->log['date'];
        $this->isBot = $this->log['isBot'];
    }
}