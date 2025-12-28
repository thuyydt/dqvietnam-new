<?php

/**
 * User: linhth
 * Created Date: 23/03/2019
 * Updated Date: 25/03/2019
 */
defined('BASEPATH') or exit('No direct script access allowed');

class C19_Controller extends CI_Controller
{
  public $template_path = '';
  public $template_main = '';
  public $templates_assets = '';
  public $_message = array();
  public $redis;
  public $_controller;
  public $_method;

  public function __construct()
  {
    parent::__construct();
    //Load library
    $this->load->library(array('session', 'email', 'form_validation', 'user_agent', 'breadcrumbs'));
    $this->load->helper(array('cookie', 'security', 'general', 'url', 'number', 'link', 'directory', 'file', 'form', 'datetime', 'data', 'debug', 'string'));
    $this->config->load('cms');
    $this->config->load('languages');
    $this->config->load('seo');
    $this->lang->load('general');
    $this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file'));

    //Load database
    $this->load->database();

    if (ACTIVE_REDIS == TRUE) {
      try {
        $this->redis = new \Redis();
        $this->redis->pconnect(REDIS_HOST, REDIS_PORT);
        if (REDIS_PASS) {
          $this->redis->auth(REDIS_PASS);
        }
      } catch (Exception $e) {
        $this->redis->close();
        $this->redis = new \Redis();
        $this->redis->pconnect(REDIS_HOST, REDIS_PORT);
        if (REDIS_PASS) {
          $this->redis->auth(REDIS_PASS);
        }
      }
    }
    $this->_controller = $this->router->fetch_class();
    $this->_method = $this->router->fetch_method();
  }

  public function get_setting($key = '')
  {
    if (isset($this->settings[$key])) {
      return $this->settings[$key];
    }
    return null;
  }

  public function sendMail($data = [
    'to' => '',
    'title' => '',
    'template' => 'default'
  ])
  {
    if (!isset($data['to'])) {
      throw new Exception("Email người nhận không hợp lệ!");
    }
    $from = $this->get_setting('email_admin');
    $siteName = $this->get_setting('email_admin');
    $this->email->from($from, $siteName);
    $this->email->to($data['to']);
    $this->email->subject(isset($data['title']) ? $data['title'] : "Thông báo từ $from");
    $this->email->message($data['template']);
    return $this->email->send();
  }


  public function getCache($key, $isObject = true)
  {
    $key = REDIS_PREFIX . $key;
    $data = ACTIVE_REDIS === TRUE ? $this->redis->get($key) : '';
    if (!empty($data) && $isObject === true) $data = json_decode($data);
    return $data;
  }

  public function setCache($key, $value = [], $timeOut = null)
  {
    $key = REDIS_PREFIX . $key;
    if (ACTIVE_REDIS !== TRUE) return false;
    $this->redis->set($key, json_encode($value), $timeOut);
  }

  public function show_404()
  {
    redirect(site_url('404_override'), 'location', 404);
  }

  public function checkRequestGetAjax($type = 0)
  {
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'))
      if ($type == 1) {
        return false;
      } else {
        die('Not Allow');
      }
    else {
      return true;
    }
  }

  public function checkRequestPostAjax($type = 0)
  {
    $check = ($this->input->server('REQUEST_METHOD') !== 'POST'
      || empty($_SERVER['HTTP_X_REQUESTED_WITH'])
      || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'));
    if ($check) {
      if ($type == 1) {
        return false;
      }
      die('Not Allow');
    }
    return true;
  }

  public function returnJson($data = null)
  {
    if (empty($data)) $data = $this->_message;
    die(json_encode($data));
  }

  public function validate_html($str)
  {
    if (!$str) {
      return false;
    }
    if ($str == strip_tags($str) && $str == html_entity_decode($str)) {
      return true;
    } else {
      $this->form_validation->set_message('validate_html', lang('form_validation_html_title'));
      return false;
    }
  }
}

class Admin_Controller extends C19_Controller
{
  public function __construct()
  {
    parent::__construct();
    //set đường dẫn template
    $this->template_path = 'admin/';
    $this->template_main = $this->template_path . '_layout';
    $this->templates_assets = base_url() . 'public/admin/';
    //fix language admin tiếng việt
    // $this->session->admin_lang = 'vi';

    $key = 'list_menu_admin';
    $list_menus = $this->cache->get($key);

    if (empty($list_menus)) {
      $this->load->model('system_menu_model');
      $list_menus = $this->system_menu_model->getMenu();
      $this->cache->save($key, $list_menus, 60 * 60 * 30);
    }
    $this->load->vars(array('list_menu' => $list_menus));
    //tải thư viện
    $this->load->library(array('ion_auth'));
    //load helper
    $this->load->helper(array('authorization', 'image', 'format', 'button', 'status'));
    //Load config
    $this->config->load('permission');
    $this->check_auth();
    //đọc file setting
    $dataSetting = file_get_contents(FCPATH . 'config' . DIRECTORY_SEPARATOR . 'settings.cfg');
    $dataSetting = $dataSetting ? json_decode($dataSetting, true) : array();
    if (!empty($dataSetting)) foreach ($dataSetting as $key => $item) {
      if ($key === 'meta') {
        $oneMeta = $item[$this->config->item('default_language')];
        if (!empty($oneMeta)) foreach ($oneMeta as $keyMeta => $value) {
          $this->settings[$keyMeta] = str_replace('"', '\'', $value);
        }
      } else
        $this->settings[$key] = $item;
    }
  }

  // add log action
  public function addLogaction($action, $note)
  {
    $this->load->model("Log_action_model", "logaction");
    $data['action'] = $action;
    $data['note'] = $note;
    $data['uid'] = $this->session->user_id;
    $dates = "%Y-%m-%d %h:%i:%s";
    $time = time();
    $data['created_time'] = mdate($dates, $time);
    $this->logaction->save($data);
  }

  public function check_auth()
  {
    //        dd($this->session);
    if (!$this->ion_auth->logged_in()) {
      //chưa đăng nhập thì chuyển về page login
      redirect(BASE_ADMIN_URL . 'auth/login?url=' . urlencode(current_url()), 'refresh');
    } else {
      if ($this->session->userdata['user_id'] != 1) {

        $this->session->admin_permission = null;
        if (!$this->session->admin_permission) {
          $this->load->model('groups_model');
          $groupModel = new Groups_model();
          $group = $groupModel->get_group_by_userid((int)$this->session->userdata('user_id'));
          $data = $groupModel->getById($group->group_id);
          if (!empty($data)) {
            $this->session->admin_permission = json_decode($data->permission, true);
          }
        }
        $cmsControllerPermission = $this->config->item('cms_controller_permission');
        $cmsCustomPer = $this->config->item('cms_custom_per');
        $cmsPerListMethod = $this->config->item('cms_per_list_method');
        $cmsNotPerMethod = $this->config->item('cms_not_per_method');

        if (in_array($this->_controller, array_merge($cmsControllerPermission, $cmsCustomPer))) {
          if (!empty($this->session->admin_permission[$this->_controller])) {
            if (in_array($this->_controller, $cmsCustomPer)) {
              $perMethod = (in_array($this->_method, $cmsPerListMethod)) ? $this->_method : $this->session->userdata[$this->_controller . '_type'];
              if (!in_array($this->_method, $cmsNotPerMethod) && (empty($perMethod) || empty($this->session->admin_permission[$this->_controller][$perMethod]['view']))) { //check quyen view
                $this->load->view($this->template_path . 'not_permission');
              } else {
                checkPer($this->session->admin_permission[$this->_controller][$perMethod]);
              }
            } else {
              if (empty($this->session->admin_permission[$this->_controller]['view'])) {
                $this->load->view($this->template_path . 'not_permission');
              } else {
                checkPer($this->session->admin_permission[$this->_controller]);
              }
            }
          } else if ($group->group_id == 2) {
            if ($this->_method == 'ajax_load' && $this->_controller = 'schools') {
              return true;
            } else {
              $this->load->view($this->template_path . 'not_permission');
            }
          } else {
            $this->load->view($this->template_path . 'not_permission');
          }
        }
      }
    }
  }

  public function setRules($field, $label, $rules)
  {
    return [
      'field' => $field,
      'label' => $label,
      'rules' => $rules
    ];
  }

  public function default_rules_lang($lang_code, $label = [])
  {
    $title = 'Tiêu đề ';
    $meta_title = 'Meta title ';
    $description = 'Tóm tắt ';
    $slug = 'Url ';
    $meta_description = 'Meta description ';
    $meta_keyword = 'Meta keyword';
    extract($label);
    $required = '';
    if ($lang_code == $this->config->item('default_language')) {
      $required = 'required|';
    }
    return array(
      array(
        'field' => 'title[' . $lang_code . ']',
        'label' => $title,
        'rules' => $required . 'trim|min_length[3]|max_length[255]|trim|xss_clean|callback_validate_html'
      ),
      array(
        'field' => 'meta_title[' . $lang_code . ']',
        'label' => $meta_title,
        'rules' => $required . 'trim|xss_clean|callback_validate_html'
      ),
      array(
        'field' => 'description[' . $lang_code . ']',
        'label' => $description,
        'rules' => 'trim|xss_clean|callback_validate_html'
      ),
      array(
        'field' => 'slug[' . $lang_code . ']',
        'label' => $slug,
        'rules' => $required . 'trim|xss_clean|callback_validate_html'
      ),
      array(
        'field' => 'meta_description[' . $lang_code . ']',
        'label' => $meta_description,
        'rules' => 'trim|xss_clean|callback_validate_html'
      ),
      array(
        'field' => 'meta_keyword[' . $lang_code . ']',
        'label' => $meta_keyword,
        'rules' => 'trim|xss_clean|callback_validate_html'
      )
    );
  }

  public function return_notify_validate($rules)
  {
    $valid = [];
    if (!empty($rules)) foreach ($rules as $item) {
      if (!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
    }
    $this->_message = array(
      'validation' => $valid,
      'type' => 'warning',
      'message' => $this->lang->line('mess_validation')
    );
    $this->returnJson();
  }

  public function max_time_current($date)
  {
    if (!empty($date)) {
      $date = str_replace('/', '-', $date);
      if (date('Y-m-d', strtotime($date)) >= date('Y-m-d')) {
        $this->form_validation->set_message('max_time_current', '%s không đúng');
        return false;
      }
    }
    return true;
  }

  public function min_time_current($date)
  {
    if (!empty($date)) {
      $date = str_replace('/', '-', $date);
      if (strtotime(date('Y-m-d', strtotime($date))) < strtotime(date('Y-m-d'))) {
        $this->form_validation->set_message('min_time_current', '%s ' . 'phải lớn hơn ngày hiện tại');
        return false;
      }
    }
    return true;
  }
}

class API_Controller extends CI_Controller
{
  protected $_json_str = '';
  protected $_settings;
  protected $key_cache;
  protected $_token;
  protected $_token_de;
  protected $redis;
  protected $_message = array();
  protected $_name_controller;
  const RESPONSE_SUCCESS = 200;
  const RESPONSE_REQUEST_ERROR = 400;
  const RESPONSE_LOGIN_ERROR = 401;
  const RESPONSE_LOGIN_DENIED = 403;
  const RESPONSE_NOT_EXIST = 404;
  const RESPONSE_SERVER_ERROR = 500;

  public $status_token;
  public $access_token;
  public $info_auth;
  public $status;
  public $user_auth;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    /*Load config*/

    /*Load libraries*/
    $this->load->library(array('JWT', 'form_validation', 'email', 'info'));
    $this->load->config('cms');
    /*Load language*/

    /*Load helper*/
    $this->load->helper(array('security', 'url', 'file', 'form', 'datetime', 'debug', 'string', 'data', 'image'));

    // Kiểm tra secret
    //        $secret = $this->input->get_request_header('secret');
    //        if (empty($secret) || $secret !== $this->config->item('secret_api')) {
    //            $this->_message = [
    //                'code' => self::RESPONSE_LOGIN_DENIED,
    //                'message' => 'Secret không đúng'
    //            ];
    //            $this->returnJson();
    //        }

    $controller = $this->router->fetch_class();
    $method = $this->router->fetch_method();
    if (!in_array($controller, array('auth', 'cronjob'))) {

      $this->check_auth();

      if (in_array($this->status_token, [404, 500]) && isset($_COOKIE['dq_try_play'])) {
        $this->user_auth = (object)[
          'id' => $_COOKIE['dq_try_play'],
          'type' => 'try'
        ];
      } else if (in_array($this->status_token, [404, 500])) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Vui lòng đăng nhập để sử dụng dịch vụ."
        ];

        $this->returnJson($this->_message);
      }

      if ($this->status_token == 400) {
        $this->_message = [
          'code' => self::RESPONSE_REQUEST_ERROR,
          "message" => "Phiên làm việc hết hạn, vui lòng đăng nhập."
        ];

        $this->returnJson($this->_message);
      }
    }

    /*Get data API request*/
    $this->_json_str = file_get_contents('php://input');

    /*Decode data API request*/
    $this->_json_str = $this->_json_str ? json_decode($this->_json_str) : '';

    /*Load database*/
    $this->load->database();
    /*Create name controller*/
    $this->_controller = $this->router->fetch_class();
    if (ACTIVE_REDIS == TRUE) {
      try {
        $this->redis = new Redis();
        $this->redis->pconnect(REDIS_HOST, REDIS_PORT);
        if (REDIS_PASS) {
          $this->redis->auth(REDIS_PASS);
        }
      } catch (Exception $e) {
        $this->redis->close();
        $this->redis = new Redis();
        $this->redis->pconnect(REDIS_HOST, REDIS_PORT);
        if (REDIS_PASS) {
          $this->redis->auth(REDIS_PASS);
        }
      }
    }
    $this->key_cache = $this->config->load('keycache');
    //        if (!empty(!empty($this->_json_str->token))) $this->_token_de = $this->jwt->decode($this->_json_str->token, JWT_CONSUMER_SECRET);
    //        if (!empty(!empty($this->input->post('token')))) $this->_token_de = $this->jwt->decode($this->input->post('token'), JWT_CONSUMER_SECRET);
  }

  public function setting($key = '')
  {
    if ($this->info->get($key) !== null) {
      return $this->info->get($key);
    }
    return null;
  }

  public function sendMail($data = [
    'to' => '',
    'title' => '',
    'template' => 'default'
  ])
  {
    if (!isset($data['to'])) {
      throw new Exception("Email người nhận không hợp lệ!");
    }

    $from = $this->setting('mail[email]');
    $siteName = $this->setting('siteName');
    $this->email->from($from, $siteName);
    $this->email->to($data['to']);
    $this->email->subject(isset($data['title']) ? $data['title'] : "Thông báo từ $from");
    $this->email->message($data['template']);
    return $this->email->send();
  }


  public function genToken($arr_data_token = array())
  {
    $arr_data_token['created_time'] = time();
    $arr_data_token['ttl'] = 7 * 24 * 60 * 60;
    $this->_token = $this->jwt->encode($arr_data_token, JWT_CONSUMER_SECRET);
  }

  public function returnJson($data = null)
  {
    if (empty($data)) $data = $this->_message;
    $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data, JSON_UNESCAPED_UNICODE))->_display();
    exit();
  }

  public function checkRequestGet()
  {
    if (!$this->input->server('REQUEST_METHOD') == 'GET') {
      $this->_message = array(
        'message' => lang('mess_api_unsuccess'),
        'code' => self::RESPONSE_REQUEST_ERROR,
      );
      $this->returnJson($this->_message);
    }

    return true;
  }

  public function checkRequestPost()
  {
    if (!($this->input->server('REQUEST_METHOD') == 'POST')) {
      $this->_message = array(
        'message' => lang('mess_api_unsuccess'),
        'code' => self::RESPONSE_REQUEST_ERROR,
      );
      $this->returnJson($this->_message);
    }

    return true;
  }

  public function getCache($key, $isObject = true)
  {
    $key = REDIS_PREFIX . $key;
    $data = ACTIVE_REDIS === TRUE ? $this->redis->get($key) : '';

    if (!empty($data) && $isObject === true) $data = json_decode($data);
    return $data;
  }

  public function setCache($key, $value = [], $timeOut = null)
  {
    $key = REDIS_PREFIX . $key;
    if (ACTIVE_REDIS !== TRUE) return false;
    $this->redis->set($key, json_encode($value), $timeOut);
  }

  public function check_auth()
  {
    $inputJSON = file_get_contents('php://input');
    $request = json_decode($inputJSON, true);
    $access_token = $this->input->get_request_header('token') ? $this->input->get_request_header('token') : $this->input->get('token');

    if (empty($access_token)) {
      // ko ton tai access_token trong request
      $this->status = 'fail';
      $this->status_token = 404;
    } else {
      $this->decodeAccessToken($access_token);
    }
  }

  public function genAccessToken($data = array(), $timeExpire = 7 * 24 * 60 * 60)
  {
    $data['timeExpire'] = time() + $timeExpire;

    if (openssl_public_encrypt(json_encode($data), $encrypted, PUBLIC_KEY) == 1) {
      $this->status = 'success';
      $this->status_token = 200;
      $this->access_token = str_replace(array('+', '/', '='), array('.', '_', '17B7'), base64_encode($encrypted));
    } else {
      // ko build dc token
      $this->status = 'fail';
      $this->status_token = 500;
    }
  }

  public function decodeAccessToken($access_token)
  {
    $access_token = base64_decode(str_replace(array('.', '_', '17B7'), array('+', '/', '='), $access_token));

    if (openssl_private_decrypt($access_token, $data, PRIVATE_KEY) == true) {

      $data = json_decode($data);
      $this->status_token = 200;
      $this->info_auth = $data;

      if ($this->info_auth->timeExpire < time()) {
        $this->status = 'fail';
        $this->status_token = 400;
      } else {
        $this->getInfoUserAuth();
      }
    } else {
      // token ko dung
      $this->status = 'fail';
      $this->status_token = 500;
    }
  }

  public function getInfoUserAuth()
  {
    $this->load->model('Account_model');
    $account_model = new Account_model();
    $this->user_auth = $account_model->getInfoUserById($this->info_auth->user_id);
    if (empty($this->user_auth)) {
      $this->status = 'fail';
      $this->status_token = 400;
    }
  }

  public function response($status, $code, $message, $data)
  {
    die(json_encode(array(
      'status' => $status,
      'code' => $code,
      'message' => $message,
      'data' => $data
    )));
  }
}

class Console_Controller extends CI_Controller
{
  public $redis;
  /**
   * @var float
   */
  public $time_start;

  public function __construct()
  {
    parent::__construct();
    //tinh thoi gian xu ly
    $this->time_start = $this->microtime_float();

    /*Load database*/
    $this->load->database();
    if (ACTIVE_REDIS === TRUE) {
      try {
        $this->redis = new Redis();
        $this->redis->pconnect(REDIS_HOST, REDIS_PORT);
        if (REDIS_PASS) {
          $this->redis->auth(REDIS_PASS);
        }
      } catch (Exception $e) {
        $this->redis->close();
        $this->redis = new Redis();
        $this->redis->pconnect(REDIS_HOST, REDIS_PORT);
        if (REDIS_PASS) {
          $this->redis->auth(REDIS_PASS);
        }
      }
    }
  }

  public function getCache($key, $isObject = true)
  {
    $key = REDIS_PREFIX . $key;
    $data = ACTIVE_REDIS === TRUE ? $this->redis->get($key) : '';
    if (!empty($data) && $isObject === true) $data = json_decode($data);
    return $data;
  }

  public function setCache($key, $value = [], $timeOut = null)
  {
    $key = REDIS_PREFIX . $key;
    if (ACTIVE_REDIS !== TRUE) return false;
    $this->redis->set($key, json_encode($value), $timeOut);
  }

  public function microtime_float()
  {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
  }

  public function __destruct()
  {
    $this->time_end = $this->microtime_float();
    echo '<p>Time process ' . ($this->time_end - $this->time_start) . 's</p>';
    //        log_message('error', $this->router->fetch_method() . ': ' . ($this->time_end - $this->time_start) . 's');
  }
}

class Public_Controller extends C19_Controller
{
  public $settings = array();
  public $_message = array();
  public $lang_code;
  public $_all_category = [];
  public $_user_login = [];
  public $layout;
  public $show_header = false;
  public $token;
  public $auth;

  public function __construct()
  {
    parent::__construct();
    //set đường dẫn template
    $this->template_path = 'public/';
    $this->template_main = $this->template_path . '_layout';
    $this->templates_assets = base_url() . 'public/';
    //load cache driver
    $this->load->driver('cache', array('adapter' => 'file'));
    //tải thư viện
    $this->load->library(('cart'));
    //load helper
    $this->load->helper(array(
      'cookie',
      'navmenus',
      'title',
      'number',
      'format',
      'image',
      'status_order',
      'status'
    ));
    //Detect mobile
    //$this->detectMobile = new Mobile_Detect();
    $this->config->load('email');
    $this->config->load('report');
    //Language
    $layout = $this->input->get_request_header('layout');
    if (!empty($layout)) {
      $this->layout = $this->session->userdata['layout'] = $layout;
    } else {
      $this->layout = $this->session->layout;
    }
    $this->loadSettings();
    $this->lang->load(array('frontend', 'general'), $this->session->public_lang_full);

    //        SiteSettings::$all = $this->settings;

    $this->checkAuth();

    //Set flash message
    $this->_message = $this->session->flashdata('message');
    if (MAINTAIN_MODE == TRUE) $this->load->view('public/coming_soon');
  }

  public function loadSettings()
  {
    $dataSetting = file_get_contents(FCPATH . 'config' . DIRECTORY_SEPARATOR . 'settings.cfg');
    $dataSetting = $dataSetting ? json_decode($dataSetting, true) : array();
    if (!empty($dataSetting)) foreach ($dataSetting as $key => $item) {
      $this->settings[$key] = $item;
    }
  }

  public function getPagination($total, $limit, $base_url, $first_url, $query_strings = false)
  {
    if (!empty($this->input->get('page'))) {
      $first_url = remove_query_arg('page');
    }
    $this->load->library('pagination');
    $paging['base_url'] = $base_url;
    $paging['first_url'] = $first_url;
    $paging['total_rows'] = $total;
    $paging['per_page'] = $limit;
    $paging['attributes'] = array('class' => 'page-link');
    $paging['page_query_string'] = $query_strings;
    $this->pagination->initialize($paging);
    return $this->pagination->create_links();
  }

  public function blockSEO($oneItem, $url)
  {
    $data = [
      'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : $oneItem->title,
      'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : $oneItem->description,
      'meta_keyword' => !empty($oneItem->meta_title) ? $oneItem->meta_keyword : '',
      'url' => $url,
      'image' => !empty($oneItem->thumbnail) ? getImageThumb($oneItem->thumbnail) : getImageThumb($this->settings['logo'])
    ];
    return $data;
  }

  public function _get_csrf_nonce()
  {
    $this->load->helper('string');
    $key = random_string('alnum', 8);
    $value = random_string('alnum', 20);
    $this->session->set_flashdata('csrfkey', $key);
    $this->session->set_flashdata('csrfvalue', $value);
    return array($key => $value);
  }

  public function checkAuth()
  {
    if (!empty($_COOKIE['account_secret'])) {
      $this->auth = $this->decodeAccessToken($_COOKIE['account_secret']);
    }
  }

  public function decodeAccessToken($access_token)
  {
    $access_token = base64_decode(str_replace(array('.', '_', '17B7'), array('+', '/', '='), $access_token));

    if (openssl_private_decrypt($access_token, $data, PRIVATE_KEY) == true) {
      $data = json_decode($data);
      if ($data->timeExpire < time()) return false;

      $user = getAccount($data->user_id);

      if (empty($user)) return false;

      $user->name = $user->username;
      $user->user_id = $user->id;
      return $user;
    }
  }
}
