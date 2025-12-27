<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->template_path = 'public/auth/';
        $this->template_main = $this->template_path . '_layout';
        $this->templates_assets = base_url() . 'public/auth/';
    }

    public function login()
    {

//        $this->load->model('Activity_model');
//        $agent = new Jenssegers\Agent\Agent();
//        $device = $agent->device();
//        $activity = new Activity_model();
//        $isLogged = $activity->check_logged_device(54, $device);
//        dd($isLogged);

        $this->settings['meta_title'] = 'Đăng Nhập';
        $status = $this->input->get('status');
        if ($status == 'register_success') redirect('payment?status=register_success');
        if (!empty($this->auth)) redirect('guide');

        $data = [];
        $data['main_content'] = $this->load->view($this->template_path . 'login', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function register($type = '')
    {
        $this->settings['meta_title'] = 'Đăng Ký';
        $layout = 'register_';
        switch ($type) {
            case 'personal':
                $layout .= $type;
                break;
            case 'school':
                $layout .= $type;
                break;
            default:
                $layout = 'register';
                break;
        }

        $this->load->model('Packages_model');
        $packages_model = new Packages_model();

        $packages = $packages_model->getData([
            'limit' => 2,
            'where' => [
                'status' => 1,
            ],
            'order' => ['id' => 'DESC']
        ]);

        $data = [
            'packages' => $packages
        ];

        $data['main_content'] = $this->load->view($this->template_path . $layout, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function forgot_password()
    {
        $this->settings['meta_title'] = 'Quên Mật Khấu';
//        if (!empty($this->auth)) redirect('guide');

        $data = [];
        $data['main_content'] = $this->load->view($this->template_path . 'forgot_password', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function payment()
    {
        $this->settings['meta_title'] = 'Thanh Toán';
        if (empty($this->auth)) redirect('login');

        $this->load->model(['payments_model']);

        if ((int)$this->auth->is_payment) redirect('hocbai');

        $data = [];
        $data['main_content'] = $this->load->view($this->template_path . 'payment', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function verify()
    {
        if (empty($this->auth)) redirect('login');

        $data = [];
        $data['main_content'] = $this->load->view($this->template_path . 'verify', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function packages()
    {
        if (empty($this->auth)) redirect('login');

        $this->load->model('Packages_model');
        $packages_model = new Packages_model();

        $packages = $packages_model->getData([
            'limit' => 2,
            'status' => 1,
            'order' => ['id' => 'DESC']
        ]);

        $data = [
            'packages' => $packages
        ];

        $data['main_content'] = $this->load->view($this->template_path . 'package', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
