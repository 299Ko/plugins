<?php

/**
 * @copyright (C) 2022, 299Ko
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @author Maxence Cauderlier <mx.koder@gmail.com>
 * 
 * @package 299Ko https://github.com/299Ko/299ko
 */
defined('ROOT') OR exit('No direct script access allowed');

$action = (isset($_GET['action'])) ? $_GET['action'] : '';

switch ($action) {
    case 'saveconf':
        if ($administrator->isAuthorized()) {
            $runPlugin->setConfigVal('theme', trim($_POST['theme']));
            if ($pluginsManager->savePluginConfig($runPlugin)) {
                show::msg("Les modifications ont été enregistrées", 'success');
            } else {
                show::msg("Une erreur est survenue", 'error');
            }
            header('location:index.php?p=highlight');
            die();
        }
        break;
    default:
}
