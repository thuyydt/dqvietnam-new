<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['socket_type'] = 'tcp';
$config['host'] = 'redis';
$config['password'] = getenv('REDIS_PASS');
$config['port'] = 6379;
$config['timeout'] = 0;