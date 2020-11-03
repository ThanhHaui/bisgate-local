<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Config for the CodeIgniter Redis library
 *
 * @see ../libraries/Redis.php
 */

$config['redis_default']['host'] = getenv('REDIS_HOST');		// IP address or host
$config['redis_default']['port'] = getenv('REDIS_PORT');			// Default Redis port is 6379
$config['redis_default']['password'] = getenv('REDIS_PASSWORD');			// Can be left empty when the server does not require AUTH