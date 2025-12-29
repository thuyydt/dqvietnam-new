<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Cache Helper Functions
 * Provides utility functions for cache management
 */

if (!function_exists('invalidate_user_cache')) {
  /**
   * Invalidate all cache related to a specific user
   * Call this function when user data changes (e.g., after completing a task)
   * 
   * @param int $user_id User ID
   * @param CI_Controller $CI CodeIgniter instance
   * @return bool Success status
   */
  function invalidate_user_cache($user_id, &$CI = null)
  {
    if ($CI === null) {
      $CI = &get_instance();
    }

    $cache_keys = [
      'user_points_' . $user_id . '_all',
      'user_points_' . $user_id . '_done',
      'account_info_' . $user_id,
      'TaskCurrent_' . $user_id,
      'Cards_' . $user_id,
    ];

    $success = true;
    foreach ($cache_keys as $key) {
      $full_key = REDIS_PREFIX . $key;
      if (ACTIVE_REDIS === TRUE && $CI->redis) {
        $result = $CI->redis->del($full_key);
        if ($result === false) {
          $success = false;
        }
      }
    }

    return $success;
  }
}

if (!function_exists('invalidate_points_cache')) {
  /**
   * Invalidate only points cache for a user
   * Use this when user completes a task or earns points
   * 
   * @param int $user_id User ID
   * @param CI_Controller $CI CodeIgniter instance
   * @return bool Success status
   */
  function invalidate_points_cache($user_id, &$CI = null)
  {
    if ($CI === null) {
      $CI = &get_instance();
    }

    $cache_keys = [
      'user_points_' . $user_id . '_all',
      'user_points_' . $user_id . '_done',
    ];

    $success = true;
    foreach ($cache_keys as $key) {
      $full_key = REDIS_PREFIX . $key;
      if (ACTIVE_REDIS === TRUE && $CI->redis) {
        $result = $CI->redis->del($full_key);
        if ($result === false) {
          $success = false;
        }
      }
    }

    return $success;
  }
}

if (!function_exists('get_cached_or_query')) {
  /**
   * Get data from cache or execute query if not cached
   * Generic helper for cache-or-query pattern
   * 
   * @param string $cache_key Cache key (without prefix)
   * @param callable $query_callback Function to execute if cache miss
   * @param int $ttl Time to live in seconds (default: 300 = 5 minutes)
   * @param CI_Controller $CI CodeIgniter instance
   * @return mixed Cached or queried data
   */
  function get_cached_or_query($cache_key, $query_callback, $ttl = 300, &$CI = null)
  {
    if ($CI === null) {
      $CI = &get_instance();
    }

    // Try to get from cache
    $data = $CI->getCache($cache_key, true);

    if (!$data) {
      // Cache miss, execute query
      $data = $query_callback();

      // Store in cache
      if ($data !== false && $data !== null) {
        $CI->setCache($cache_key, $data, $ttl);
      }
    }

    return $data;
  }
}
