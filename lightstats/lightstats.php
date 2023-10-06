<?php

/**
 * @copyright (C) 2022, 299Ko
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @author Maxence Cauderlier <mx.koder@gmail.com>
 * 
 * @package 299Ko https://github.com/299Ko/299ko
 */
defined('ROOT') OR exit('No direct script access allowed');

/**
 * Install function
 */
function lightstatsInstall() {
    @mkdir(DATA_PLUGIN . 'lightstats/logs');
    @chmod(DATA_PLUGIN . 'lightstats/logs', 0755);
}

function lightstatsAddScript() {
    echo '<script src=" https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js "></script>';
}

function lightstatsAddVisitor() {

// Get the IP address of the visitor
    $ip = $_SERVER['REMOTE_ADDR'];

// Get the referrer of the visitor
    $referer = $_SERVER['HTTP_REFERER'] ?? '';

// Get the user agent of the visitor
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

// Check if the user agent is a bot
    $isBot = isBot($userAgent);

// Get the current date and time
    $date = date("Y-m-d H:i:s");

    $folder = DATA_PLUGIN . 'lightstats/logs/' . date("Y/m") . '/';
    @mkdir($folder, 0755, true);
    
    $filename = $folder . date("d") .'.json';
   
    if (is_file($filename)) {
        $logs = util::readJsonFile($filename);
    } else {
        $logs = [];
    }

// Create an array with the data to be stored
    $data = array(
        "ip" => $ip,
        "page" => $_SERVER['REQUEST_URI'],
        "referer" => $referer,
        "userAgent" => $userAgent,
        "isBot" => $isBot,
        "date" => $date
    );
    
    array_push($logs, $data);
    util::writeJsonFile($filename, $logs);
}

function isBot($userAgent) {
    $bots = array("Googlebot", "Bingbot", "Yahoo", "Baiduspider", "YandexBot", 
        "Applebot", "Facebot");
    foreach ($bots as $bot) {
        if (stripos($userAgent, $bot) !== false) {
            return true;
        }
    }
    return false;
}