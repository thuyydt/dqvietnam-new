<?php

$root = str_replace('\\','/',dirname(__FILE__));

if (getenv('CI_ENV') === 'production') {
    define('BASE_URL', 'https://dqvietnam.edu.vn/');
    define('BASE_ADMIN_URL', 'https://dqvietnam.edu.vn/admin/');
    define('BASE_SCRIPT_NAME', '/');
} else {
    $domain = $_SERVER['HTTP_HOST'];
    $script_name = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    $domain .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    $base = "http://" . $domain;
    if (!empty($_SERVER['HTTPS'])) $base = "https://" . $domain;
    define('BASE_URL', $base);
    define('BASE_ADMIN_URL', $base."admin/");
    define('BASE_SCRIPT_NAME', $script_name);
}
define('MEDIA_NAME',"public/media/");
define('MEDIA_PATH',$root.'/'.MEDIA_NAME);
define('MEDIA_URL',BASE_URL . MEDIA_NAME);
define('MINIFY', getenv('CI_MINIFY') === 'true');

//CONFIG BASE
define('CMS_VERSION','4.3');
define('MAINTAIN_MODE', getenv('CI_MAINTAIN_MODE') === 'true'); // Enable or disable maintain mode
define('DEBUG_MODE', getenv('CI_DEBUG') === 'true');

// Version for CSS/JS caching
if (DEBUG_MODE) {
    define('ASSET_VERSION', time());
} else {
    define('ASSET_VERSION', '1.0.0');
}
define('CACHE_MODE', getenv('CI_CACHE') !== 'false');
define('CACHE_TIMEOUT_LOGIN',1800);

//CONFIG DB
define('DB_DEFAULT_HOST','mysql');
define('DB_DEFAULT_USER', getenv('DB_DEFAULT_USER'));
define('DB_DEFAULT_PASSWORD', getenv('CI_DB_PASSWORD'));
define('DB_DEFAULT_NAME','cauvong');
define('PRIVATE_KEY', getenv('RSA_PRIVATE_KEY') ?: '');
define('PUBLIC_KEY', getenv('RSA_PUBLIC_KEY') ?: '');

//CONFIG ZALO
/*
define('ZALO_APP_ID_CFG','32911618423593379');
define('ZALO_APP_SECRET_KEY_CFG','T5Y8HSfJDEj1YnvQUT8U');
define('ZALO_CAL_BACK',BASE_URL.'auth/loginzalo');
*/

//CONFIG FB
define('FB_API', getenv('FB_API') ?: '');
define('FB_SECRET', getenv('FB_SECRET') ?: '');
define('FB_VER','v3.2');

//CONFIG GOOGLE
define('GG_API', getenv('GG_API') ?: '');
define('GG_SECRET', getenv('GG_SECRET') ?: '');
define('GG_KEY', getenv('GG_KEY') ?: '');
define('GG_CAPTCHA_SITE_KEY', getenv('GG_CAPTCHA_SITE_KEY') ?: '');
define('GG_CAPTCHA_SECRET_KEY', getenv('GG_CAPTCHA_SECRET_KEY') ?: '');
//JWT KEY
define('JWT_CONSUMER_KEY', getenv('JWT_CONSUMER_KEY') ?: '');
define('JWT_CONSUMER_SECRET', getenv('JWT_CONSUMER_SECRET') ?: '');
define('JWT_CONSUMER_TTL',86400);

//CONFIG MEMCACHE
/*
define('MEMCACHE_MODE',FALSE);
define('MEMCACHE_HOST','127.0.0.1');
define('MEMCACHE_PORT','11211');
define('MEMCACHE_PREFIX','prefix_');
*/

//CONFIG REDIS

define('ACTIVE_REDIS',TRUE);
define('REDIS_HOST', getenv('REDIS_HOST') ?: 'redis');
define('REDIS_PORT', getenv('REDIS_PORT') ?: '6379');
define('REDIS_PASS', getenv('REDIS_PASS') ?: '');
define('REDIS_PREFIX', getenv('REDIS_PREFIX') ?: 'dqedu_');
