<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guide extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->settings['meta_title'] = 'Hướng Dẫn';
        $this->template_path = 'public/guide/';
        $this->template_main = $this->template_path . '_layout';
        $this->templates_assets = base_url() . 'public/guide/';
    }

    public function step()
    {
        $type = $this->input->get('type');

        if ($type == 'try_game') {
            $ip = getClientIP();
            setcookie('dq_try_play', $ip, time() + (86400 * 30), "/");
            setcookie('type_play', "try");
            goto try_game;
        }

        if (empty($this->auth)) redirect('login');

        setcookie('type_play', "real");
        $this->load->model(['report_model']);
        $report_model = new Report_model();
        $playOld = $report_model->checkExistLogsPlay($this->auth->user_id);

        if ($playOld) redirect('hocbai');

        try_game:

        $data = ['step' => 1];
        $data['main_content'] = $this->load->view($this->template_path . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
