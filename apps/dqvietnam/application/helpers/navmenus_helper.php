<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function menuPrimaryLeft($classname = '', $id = '', $submenuclass = '')
{
  return menus(1, $classname, $id, $submenuclass);
}

function menuPrimaryRight($classname = '', $id = '', $submenuclass = '')
{
  return menus(4, $classname, $id, $submenuclass);
}

function menuFooter1($classname = '', $id = '', $submenuclass = '')
{
  return menus(2, $classname, $id, $submenuclass);
}

function menuFooter2($classname = '', $id = '', $submenuclass = '')
{
  return menus(3, $classname, $id, $submenuclass);
}

function menus($location, $classname, $id, $submenuclass)
{
  $ci = &get_instance();

  if (!$ci->cache->get('listmenu_' . $location . '_' . $ci->session->public_lang_code)) {
    $ci->load->model('menus_model');
    $ci->load->library('NavsMenu');
    $ci->load->helper('link');
    $menuModel = new Menus_model();
    $q = $menuModel->getMenu($location, $ci->session->public_lang_code);
    $menuModel->listmenu($q);

    $listMenu = $menuModel->listmenu;
    $navsMenu = new NavsMenu();
    $navsMenu->set_items($listMenu);
    $config['nav_tag_open'] = "<ul id='$id' class='$classname'>";
    $config['parent_tag_open'] = "<li class='%s'>";
    //$config['item_anchor']          = '<a href=\'%s\' class='smooth' title=\'%s\'>%s</a>';
    //$config['parent_anchor']          = '<a href=\'%s\' class='smooth' title=\'%s\'>%s</a>';
    $config['item_active_class'] = '';
    $config['children_tag_open'] = "<ul class='$submenuclass'>";
    $navsMenu->initialize($config);
    $menuHtml = $navsMenu->render();
    $ci->cache->save('listmenu_' . $location . '_' . $ci->session->public_lang_code, $menuHtml, 60 * 60 * 30);
  }
  $menuHtml = $ci->cache->get('listmenu_' . $location . '_' . $ci->session->public_lang_code);
  return $menuHtml;
}

function menus_main($classname = '', $id = '', $submenuclass = '')
{
  $ci = &get_instance();

  $ci->load->helper('link');
  $ci->load->helper('url');

  if (!$data = $ci->cache->get('menu_main_data')) {
    $ci->load->model('Pages_model');
    $ci->load->library('NavsMenu');

    $pageModel = new Pages_model();

    $data = $pageModel->getData([
      'where' => [
        'status' => 1,
        'layout' => 'page',
        'location !=' => 0
      ],
      'order' => [
        'sort' => 'ASC'
      ]
    ]);
    $ci->cache->save('menu_main_data', $data, 60 * 60 * 30);
  }

  $right = $left = '';
  $slug = $ci->uri->segment(1);
  if (!empty($data)) foreach ($data as $page) {
    $active = $page->slug == $slug ? 'active' : '';
    $link = BASE_URL . $page->slug;
    $is_external = false;
    if (!empty($page->outer_link)) {
      $link = $page->outer_link;
      $is_external = true;
    }

    $attr = "";
    if ($is_external) {
      $attr = 'target="_blank" rel="noopener noreferrer"';
    }
    $name_attr = htmlspecialchars($page->name, ENT_QUOTES, 'UTF-8');

    if ($page->location == 1) {
      $right .= "<li class='nav-item'><a href='$link' class='nav-link $active' title='$name_attr' $attr>$page->name</a></li>";
    } else {
      $left .= "<li class='nav-item'><a href='$link'  class='nav-link $active' title='$name_attr' $attr>$page->name</a></li>";
    }
  }

  $menuHtml = $ci->load->view($ci->template_path . '_block/menu', compact('right', 'left'), TRUE);
  // $ci->cache->save('menu_main', $menuHtml, 60 * 60 * 30);
  // }
  //$menuHtml = $ci->cache->get('menu_main');
  return $menuHtml;
}

function menus_footer($classname = '', $id = '', $submenuclass = '')
{
  $ci = &get_instance();

  //if (!$ci->cache->get('menus_footer')) {

  $ci->load->model('Pages_model');
  $ci->load->library('NavsMenu');
  $ci->load->helper('link');
  $pageModel = new Pages_model();

  $data = $pageModel->getData([
    'where' => ['status' => 1],
    'order' => [
      'sort' => 'ASC'
    ]
  ]);

  $menuHtml = "<ul class='$classname'>";
  if (!empty($data)) foreach ($data as $page) {
    $link = BASE_URL . $page->slug;
    $is_external = false;
    if (!empty($page->outer_link)) {
      $link = $page->outer_link;
      $is_external = true;
    }

    $attr = "";
    if ($is_external) {
      $attr = 'target="_blank" rel="noopener noreferrer"';
    }
    $name_attr = htmlspecialchars($page->name, ENT_QUOTES, 'UTF-8');

    $menuHtml .= "<li class='nav-item'><a href='$link' class='nav-link' title='$name_attr' $attr>$page->name</a></li>";
  }
  $menuHtml .= '</ul>';

  //  $ci->cache->save('menus_footer', $menuHtml, 60 * 60 * 30);
  // }
  //$menuHtml = $ci->cache->get('menus_footer');
  return $menuHtml;
}
