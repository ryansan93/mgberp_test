
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core Config File
 */

// Site Details
$config['connection'] = array(
	'default' => array(
		'driver'    => 'sqlsrv',

		// NOTE : TEST DATABASE
		'host'      => '103.137.111.6',
		'port'		=> '14330',
		'database'  => 'mgb_erp_test',
		'username'  => 'sa',
		'password'  => 'Mgb654321',

		// NOTE : LOCAL DATABASE
		// 'host'      => 'localhost',
		// 'database'  => 'mgb_erp_live',
		// 'username'  => '',
		// 'password'  => '',

		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
	),

	'log' => array(
		'driver'    => 'sqlsrv',

		// NOTE : TEST DATABASE
		'host'      => '103.137.111.6',
		'port'		=> '14330',
		'database'  => 'log_history_mgb_erp_test',
		'username'  => 'sa',
		'password'  => 'Mgb654321',

		// NOTE : LOCAL DATABASE
		// 'host'      => 'localhost',
		// 'database'  => 'log_history_mgb_erp',
		// 'username'  => '',
		// 'password'  => '',

		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
	),
);
