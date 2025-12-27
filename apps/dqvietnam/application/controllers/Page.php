<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends Public_Controller
{
    public $_data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['pages_model']);
        $this->_data = new Pages_model();
    }

    public function _404()
    {
        $this->output->set_status_header('404');
        $data['heading'] = '404 Page Not Found';
        $data['message'] = 'The page you requested was not found.';
        $this->load->view('errors/html/error_404', $data);
    }

    public function index($slug)
    {
        $id = $this->_data->slugToId($slug);
        $data['main'] = $main = $this->_data->getById($id, '');

        if (empty($main)) {
            return $this->_404();
        }

        $data['SEO'] = [
            'meta_title' => !empty($main->meta_title) ? $main->meta_title : (isset($this->settings['title']) ? $this->settings['title'] : $this->settings['meta_title']),
            'meta_description' => !empty($main->meta_description) ? $main->meta_description : '',
            'meta_keyword' => !empty($main->meta_keyword) ? $main->meta_keyword : '',
            'url' => BASE_URL . $slug,
            'image' => !empty($main->thumbnail) ? getImageThumb($main->thumbnail) : ''
        ];

        $data['main_content'] = $this->load->view($this->template_path . 'page/page', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function aboutDq($slug)
    {
        $id = $this->_data->slugToId($slug);
        $data['main'] = $main = $this->_data->getById($id, '');
        $data['main_content'] = $this->load->view($this->template_path . 'page/static/about', $data, TRUE);

        $this->load->view($this->template_main, $data);
    }

    public function heroDq($slug)
    {
        $id = $this->_data->slugToId($slug);
        $data['main'] = $main = $this->_data->getById($id, '');
        $data['main_content'] = $this->load->view($this->template_path . 'page/static/hero', $data, TRUE);

        $this->load->view($this->template_main, $data);
    }

    public function parent($slug)
    {
        $id = $this->_data->slugToId($slug);
        $data['main'] = $main = $this->_data->getById($id, '');
        $data['main_content'] = $this->load->view($this->template_path . 'page/static/parent', $data, TRUE);

        $this->load->view($this->template_main, $data);
    }

    public function support($slug)
    {
        $id = $this->_data->slugToId($slug);
        $data['main'] = $main = $this->_data->getById($id, '');
        $data['main_content'] = $this->load->view($this->template_path . 'page/static/support', $data, TRUE);

        $this->load->view($this->template_main, $data);
    }

    public function school($slug)
    {
        $id = $this->_data->slugToId($slug);
        $data['main'] = $main = $this->_data->getById($id, '');
        $data['main_content'] = $this->load->view($this->template_path . 'page/static/school', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function terms($slug)
    {
        $id = $this->_data->slugToId($slug);
        $data['main'] = $main = $this->_data->getById($id, '');
        $data['main_content'] = $this->load->view($this->template_path . 'page/static/terms', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function policy($slug)
    {
        $id = $this->_data->slugToId($slug);
        $data['main'] = $main = $this->_data->getById($id, '');
        $data['main_content'] = $this->load->view($this->template_path . 'page/static/policy', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
