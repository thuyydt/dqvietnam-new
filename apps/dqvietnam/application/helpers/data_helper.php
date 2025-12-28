<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('getSchool')) {

  function getSchool($id)
  {
    $_this = &get_instance();
    $_this->load->model('Schools_model');
    $_model = new Schools_model();
    return $_model->getById($id);
  }
}

if (!function_exists('getPackage')) {
  function getPackage($id)
  {
    $_this = &get_instance();
    $_this->load->model('Packages_model');
    $_model = new Packages_model();
    return $_model->getById($id);
  }
}

if (!function_exists('getAccount')) {
  function getAccount($id)
  {
    $_this = &get_instance();
    $_this->load->model('Account_model');
    $_model = new Account_model();
    return $_model->getById($id);
  }
}

if (!function_exists('getClientIP')) {
  function getClientIP()
  {
    $ipaddress = false;
    if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
      $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
    return $ipaddress;
  }
}

if (!function_exists('convert_field_to_key')) {
  function convert_field_to_key($data, $key = 'id')
  {
    $result = [];
    if (!empty($data)) foreach ($data as $k => $item) {
      $field = is_object($item) ? $item->{$key} : $item[$key];
      $result[$field] = $item;
    }
    return $result;
  }
}

if (!function_exists('convertTaskQuest')) {
  function convertTaskQuest($content, $str, $key, $key_answer)
  {
    $_this = &get_instance();
    $replace = "";
    $_this->load->model(['report_model']);
    $report_model = new Report_model();
    $answer = $report_model->getAnswerByAccountId($_this->auth->user_id, $key);

    if (!empty($answer)) {

      $question = json_decode($answer->task, true)['task_detail'];
      $content_answer = json_decode($answer->answer, true);

      $id_answer = $question[$key_answer]['id'];

      $res = $content_answer[$id_answer] ?? null;

      if (!empty($res)) {
        if (is_array($res)) {
          $replace = $_this->config->config[$str][$res[0]];
        } else if ($res == 'A') {
          $replace = $_this->config->config[$str][1];
        } else if ($res == 'B') {
          $replace = $_this->config->config[$str][2];
        }
      }
    }

    return str_replace("{{" . $str . "}}", $replace, $content);
  }
}

if (!function_exists('contentReport')) {
  function contentReport($content)
  {
    $content = strip_tags($content);

    $list_key = [
      ['name' => 'task_2_quest_1', 'key' => 2, 'key_answer' => 0],
      ['name' => 'task_12_quest_1', 'key' => 12, 'key_answer' => 0],
      ['name' => 'task_23_quest_1', 'key' => 23, 'key_answer' => 0],
      ['name' => 'task_33_quest_3', 'key' => 33, 'key_answer' => 2],
      ['name' => 'task_50_quest_2', 'key' => 50, 'key_answer' => 1],
      ['name' => 'task_60_quest_2', 'key' => 60, 'key_answer' => 1],
      ['name' => 'task_70_quest_2', 'key' => 70, 'key_answer' => 1],
      ['name' => 'task_72_quest_1', 'key' => 72, 'key_answer' => 0],
    ];

    foreach ($list_key as $key) {
      if (strstr($content, '{{' . $key['name'] . '}}')) {
        $content = convertTaskQuest($content, $key['name'], $key['key'], $key['key_answer']);
      }
    }

    $content = preg_split("/\r\n|\n|\r/", $content);

    $result = "";
    foreach ($content as $item) {
      if (empty($item)) continue;

      $result .= "<p>" . $item . "</p>";
    }

    return $result;
  }
}
