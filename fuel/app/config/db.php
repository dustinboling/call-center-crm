<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

return array(
	'active' => Config::get('environment'),

	Fuel::DEVELOPMENT => array(
		'type'			=> 'mysqli',
		'connection'	=> array(
			'hostname'   => 'localhost',
			'database'   => 'crm',
			'username'   => 'prod_web_usr',
			'password'   => 'Q7rvT9jxN4',
			'persistent' => false,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => false,
		'profiling'    => false,
	),

	Fuel::PRODUCTION => array(
		'type'			=> 'mysql',
		'connection'	=> array(
			'hostname'   => 'localhost',
			'database'   => 'fuel_prod',
			'username'   => 'root',
			'password'   => '',
			'persistent' => false,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => false,
		'profiling'    => false,
	),

	Fuel::TEST => array(
		'type'			=> 'mysqli',
		'connection'	=> array(
			'hostname'   => 'localhost',
			'database'   => 'devcrm',
			'username'   => 'cballinger',
			'password'   => '*4nub1s',
			'persistent' => false,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => false,
		'profiling'    => false,
	),

	Fuel::STAGE => array(
		'type'			=> 'mysql',
		'connection'	=> array(
			'hostname'   => 'localhost',
			'database'   => 'fuel_stage',
			'username'   => 'root',
			'password'   => '',
			'persistent' => false,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => false,
		'profiling'    => false,
	),

	'redis' => array(
		'default' => array(
			'hostname'	=> '127.0.0.1',
			'port'		=> 6379,
		)
	),
    
        'mongo' => array(
            'default' => array(
                'hostname' => 'localhost',
                'database' => 'crm',
		'username' => 'prod_web_usr',
		'password' => 'Q7rvT9jxN4'
            )
        )

);

/* End of file db.php */
