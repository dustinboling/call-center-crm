<?php
/**
 * Set error reporting and display errors settings.  You will want to change these when in production.
 */
error_reporting(-1);
ini_set('display_errors', 1);

// Use an anonymous function to keep the global namespace clean
call_user_func(function() {

	/**
	 * Set all the paths here
	 */
	$app_path		= '../fuel/app/';
	$package_path	= '../fuel/packages/';
	//$core_path	= '/var/www/frameworks/fuel/core/';
	$core_path		= '../fuel/core';


	/**
	 * Website docroot
	 */
	define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);

	( ! is_dir($app_path) and is_dir(DOCROOT.$app_path)) and $app_path = DOCROOT.$app_path;
	( ! is_dir($core_path) and is_dir(DOCROOT.$core_path)) and $core_path = DOCROOT.$core_path;
	( ! is_dir($package_path) and is_dir(DOCROOT.$package_path)) and $package_path = DOCROOT.$package_path;

	define('APPPATH', realpath($app_path).DIRECTORY_SEPARATOR);
	define('PKGPATH', realpath($package_path).DIRECTORY_SEPARATOR);
	define('COREPATH', realpath($core_path).DIRECTORY_SEPARATOR);

});

// Get the start time and memory for use later
defined('FUEL_START_TIME') or define('FUEL_START_TIME', microtime(true));
defined('FUEL_START_MEM') or define('FUEL_START_MEM', memory_get_usage());

// Boot the app
require_once APPPATH.'bootstrap.php';

// Generate the request, execute it and send the output.
$response = Request::factory()->execute()->response();

// This will add the execution time and memory usage to the output.
// Comment this out if you don't use it.
$bm = Profiler::app_total();
$response->body(str_replace(array('{exec_time}', '{mem_usage}'), array(round($bm[0], 4), round($bm[1] / pow(1024, 2), 3)), $response->body()));

$response->send(true);

// Fire off the shutdown event
Event::shutdown();

// Make sure everything is flushed to the browser
ob_end_flush();

/* End of file index.php */