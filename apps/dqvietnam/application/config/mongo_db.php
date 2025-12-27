<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['mongo_db']['active_config_group'] = 'default';

/**
 *  Connection settings for #default group.
 */
$config['mongo_db']['default'] = [
    'settings' => [
        'auth'             => FALSE,
        'debug'            => (ENVIRONMENT !== 'production'),
        'return_as'        => 'object',
        'auto_reset_query' => TRUE
    ],

    'connection_string' => '',

    'connection' => [
        'host'          => DB_MONGO_HOST,
        'port'          => DB_MONGO_PORT,
        'user_name'     => DB_MONGO_USER,
        'user_password' => DB_MONGO_PASSWORD,
        'db_name'       => DB_MONGO_NAME,
        'db_options'    => []
    ],

    'driver' => []
];

/* End of file mongo_db.php */
/* Location: ./application/config/mongo_db.php */
