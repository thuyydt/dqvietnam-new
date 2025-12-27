<?php
#defined('BASEPATH') OR exit('No direct script access allowed');
#ini_set('display_errors', '1');
#ini_set('display_startup_errors', '1');
#error_reporting(E_ALL);

class Home extends Public_Controller
{
    private $_data_page;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['pages_model']);
        $this->_data_page = new Pages_model();
    }

    public function index()
    {
        $data= [];

        $data['SEO'] = [
            'meta_title' => 'Trang chủ - DQ Vietnam',
            'meta_description' => 'DQ Vietnam - Nền tảng giáo dục và truyền thông hàng đầu. Cung cấp các giải pháp học tập và phát triển kỹ năng toàn diện.',
            'meta_keyword' => 'DQ Vietnam, giáo dục, truyền thông, học trực tuyến, kỹ năng sống',
            'url' => base_url(),
            'image' => base_url('public/images/logo-01.png')
        ];

        $data['pages'] = $this->_data_page->getPageByLayout(['hero', 'rules', 'privacy', 'support', 'active_account', 'tutorial', 'faqs', 'payment_guide']);
        $data['pages'] = convert_field_to_key($data['pages'], 'layout');

        $data['main_content'] = $this->load->view($this->template_path . 'home/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function load($files)
    {
        $files = explode('-', $files);
        if (count($files) > 0) {
            $lang_text = '';
            foreach ($files as $file) {
                $this->lang->load(trim($file));
                foreach ($this->lang->language as $key => $lang) {
                    $lang_text .= "language['" . $key . "'] = '" . $lang . "';";
                }
            }
            print $lang_text;
            exit;
        }
    }
}
