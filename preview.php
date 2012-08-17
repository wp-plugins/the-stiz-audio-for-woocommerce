<?php
/**
 * @file Instantiate a WCJDServiewAudio instance and allow it handle the request.
 */

define('WCJD_ROOT', dirname(__FILE__));
include_once WCJD_ROOT.'/../../../wp-config.php';
include_once WCJD_ROOT.'/include.php';

$server = new WCJDServeAudio($_GET);

// Determine whether this is a valid request
if ($server->validRequest()) {
    $server->output();
    die();
} else {
    header('HTTP/1.1 403 Forbidden');
    include WCJD_ROOT.'/views/error/403.php';
}
