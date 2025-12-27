<?php

/**
 * User: askeyh3t
 * Date: 25/03/2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('connectRedis')) {
    function connectRedis()
    {
        if (ACTIVE_REDIS == TRUE) {
            try {
                $redis = new Redis();
                $redis->pconnect(REDIS_HOST, REDIS_PORT);
                if (REDIS_PASS) {
                    $redis->auth(REDIS_PASS);
                }
            } catch (Exception $e) {
                $redis->close();
                $redis = new Redis();
                $redis->pconnect(REDIS_HOST, REDIS_PORT);
                if (REDIS_PASS) {
                    $redis->auth(REDIS_PASS);
                }
            }
        }
        return $redis;
    }
}

function setting($key)
{
    if (isset($settings[$key])) {
        return $settings[$key];
    }
    return '';
}
