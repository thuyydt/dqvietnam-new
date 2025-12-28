<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('getUrlCateNews')) {
  function getUrlCateNews($optional)
  {

    if (is_object($optional)) $optional = (array)$optional;
    $id = $optional['id'];
    if (!empty($optional['slug'])) {
      $slug = $optional['slug'];
    } else {
      $_this = &get_instance();
      $_this->load->model('category_model');
      $categoryModel = new Category_model();
      $dataSlug = $categoryModel->getUrl($id);
      if (!empty($dataSlug)) {
        $slug = $dataSlug->slug;
      } else {
        $slug = '';
      }
    }
    $linkReturn = BASE_URL_LANG;
    $linkReturn .= "$slug-c$id";
    if (isset($optional['page'])) $linkReturn .= '/page/';
    return $linkReturn;
  }
}

if (!function_exists('getYoutubeKey')) {
  function getYoutubeKey($url)
  {
    if (!empty($url)) {
      preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
      $youtube_id = $match[1];
      return trim($youtube_id);
    }
    return false;
  }
}

if (!function_exists('getUrlNews')) {
  function getUrlNews($optional)
  {
    if (is_object($optional)) $optional = (array)$optional;
    $id = $optional['id'];
    $slug = $optional['slug'];
    $linkReturn = BASE_URL_LANG;
    $linkReturn .= "$slug-d$id";
    if (isset($optional['page'])) $linkReturn .= '/page/';
    return $linkReturn;
  }
}
if (!function_exists('getUrlProService')) {
  function getUrlProService($optional)
  {
    if (is_object($optional)) $optional = (array)$optional;
    $id = $optional['id'];
    $slug = $optional['slug'];
    $linkReturn = BASE_URL_LANG;
    $linkReturn .= "$slug-d$id";
    if (isset($optional['page'])) $linkReturn .= '/page/';
    return $linkReturn;
  }
}

if (!function_exists('getUrlCareer')) {
  function getUrlCareer($optional)
  {
    if (is_object($optional)) $optional = (array)$optional;
    $id = $optional['id'];
    $slug = $optional['slug'];
    $isFirstLink = $optional['isFirstLink'];
    $linkReturn = BASE_URL_LANG;
    $linkReturn .= "$slug-cc$id";
    if (isset($optional['page'])) $linkReturn .= '/page/';
    if (sizeof($_GET) > 0 && $isFirstLink) {
      $linkReturn .= '/page/1?page';
      isset($_GET['q']) ? $linkReturn .= '&q=' . $_GET['q'] : $linkReturn .= '&q=';
      isset($_GET['l']) ? $linkReturn .= '&l=' . $_GET['l'] : $linkReturn .= '&l=';
      isset($_GET['t']) ? $linkReturn .= '&t=' . $_GET['t'] : $linkReturn .= '&t=';
    }
    return $linkReturn;
  }
}

if (!function_exists('getUrlCareerDetails')) {
  function getUrlCareerDetails($optional)
  {
    if (is_object($optional)) $optional = (array)$optional;
    $id = $optional['id'];
    $slug = $optional['slug'];
    $linkReturn = BASE_URL_LANG;
    $linkReturn .= "$slug-ccd$id";
    return $linkReturn;
  }
}

if (!function_exists('getUrlPage')) {

  function getUrlPage($optional = [])
  {

    if (empty($optional)) return 'javascript:;';
    $_this = &get_instance();
    if (is_object($optional)) $optional = (array)$optional;
    $linkReturn = BASE_URL;
    if (empty($optional)) goto end;
    if (!empty($optional['slug'])) {
      $slug = $optional['slug'];
      $linkReturn .= "$slug";
    } else {
      $_this->load->model('pages_model');
      $pageModel = new pages_model();
      $data = $pageModel->getById($optional['id'], '*');
      $linkReturn .= "$data->slug";
    }
    if (isset($optional['page'])) $linkReturn .= '/page/';
    end:
    return $linkReturn;
  }
}

if (!function_exists('getUrlCateProduct')) {
  function getUrlCateProduct($optional)
  {
    if (is_object($optional)) $optional = (array)$optional;
    $id = $optional['id'];
    $slug = $optional['slug'];
    $linkReturn = BASE_URL_LANG;
    $linkReturn .= "$slug-cp$id";
    if (isset($optional['page'])) $linkReturn .= '/page/';
    return $linkReturn;
  }
}


if (!function_exists('getUrlProduct')) {
  function getUrlProduct($optional)
  {
    if (is_object($optional)) $optional = (array)$optional;
    $id = $optional['id'];
    $slug = $optional['slug'];
    $linkReturn = BASE_URL_LANG;
    $linkReturn .= "$slug-p$id";
    return $linkReturn;
  }
}
if (!function_exists('getUrlProfile')) {
  function getUrlProfile($slug = '')
  {
    $linkReturn = BASE_URL_LANG . 'profile/';
    $linkReturn .= $slug;
    return $linkReturn;
  }
}
if (!function_exists('getUrlOrderDetail')) {
  function getUrlOrderDetail($codeOrder)
  {
    $linkReturn = BASE_URL_LANG;
    $linkReturn .= 'profile/orderdetail/' . $codeOrder;
    return $linkReturn;
  }
}
if (!function_exists('getUrlAccount')) {
  function getUrlAccount($optional, $action)
  {
    if (is_object($optional)) $optional = (array)$optional;
    $slug = $optional['slug'];
    $linkReturn = BASE_URL_LANG;
    if (!empty($slug)) $linkReturn .= $slug;
    if (!empty($action)) $linkReturn .= '/' . $action;
    if (isset($optional['page'])) $linkReturn .= '/page/';
    return $linkReturn;
  }
}
if (!function_exists('getUrlAjax')) {

  function getUrlAjax($optional = [])
  {
    if (is_object($optional)) $optional = (array)$optional;
    $linkReturn = BASE_URL_LANG;
    $slug = $optional['slug'];
    $linkReturn .= "$slug";
    if (isset($optional['page'])) $linkReturn .= '/';
    return $linkReturn;
  }
}
if (!function_exists('getUrlGeneral')) {

  function getUrlGeneral($optional = [])
  {
    if (is_object($optional)) $optional = (array)$optional;
    $linkReturn = BASE_URL_LANG;
    $slug = $optional['slug'];
    $linkReturn .= "$slug";
    if (isset($optional['page'])) $linkReturn .= '/';
    return $linkReturn;
  }
}
if (!function_exists('urlRoute')) {

  function urlRoute($route = '')
  {
    return BASE_URL . $route;
  }
}

if (!function_exists('urlActiveRoute')) {

  function urlActiveRoute($route = '')
  {
    if ($_SERVER['REQUEST_URI'] == '/' && !$route) {
      return 'active';
    }
    $uri = explode('/', $_SERVER['REQUEST_URI'])[1];
    if ($uri == $route) {
      return 'active';
    }
    return '';
  }
}
