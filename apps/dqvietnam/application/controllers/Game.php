<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Game extends Public_Controller
{
    public $taskModel;
    public $user_id;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['task_model', 'report_model', 'account_model', 'payments_model']);

        if (!empty($this->auth)) {
            $this->user_id = $this->auth->user_id;
        } else if (empty($this->auth) && !empty($_COOKIE['dq_try_play'])) {
            $this->user_id = $_COOKIE['dq_try_play'];
        } else {
            redirect('login');
            return;
        }

        $this->settings['meta_title'] = 'Bài học';
        $this->template_path = 'public/game/';
        $this->template_main = $this->template_path . '_layout';
        $this->templates_assets = base_url() . 'public/game/';
    }

    public function index()
    {
//        ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

        if (get_cookie('type_play') == 'try') {
            redirect('login?status=login_try_game');
        }
        if (empty($this->auth)) {
            redirect('login?status=login_try_game');
        }

        if (!(int)$this->auth->is_payment) {
            redirect('payment?status=have_to_pay');
        }

        $auth = $this->auth;
        $key = 'TaskCurrent_' . $auth->id;
        $turn = (int)$this->getCache($key);

        $this->taskModel = new Task_model();
        $task = $this->taskModel->getById($turn);

        if (!$turn || !$task) {
            $this->load->model(['report_model']);
            $report_model = new Report_model();
            $playOld = $report_model->checkExistLogsPlay($this->auth->user_id);

            if (!empty($playOld)) {
                $this->setCache($key, $playOld->task_id);
                $turn = $playOld->task_id;
            } else {
                $turn = 0;
                goto turnFirst;
            }
        }
        $task = $this->taskModel->getById($turn);
        //if (empty($task)) return;

        $turn = (int)$task->key;

        turnFirst:
        $turn += 1;

        // GET REPORT POINT
        $reportModel = new Report_model();
        if ($turn <= 80) {
            $points = $reportModel->getCountPointForType($this->user_id);
        } else {
            $points = $reportModel->getCountPointForType($this->user_id, '', 1);
        }
        $medium = 0;
        $list = [];
        if (!empty($points)) {
            foreach ($points as $key => $point) {
                $count_point = (int)$point->point_dq;
                $medium += $count_point;
                $list[$point->task_type_point] = $count_point;
            }
            // tính điểm trung bình
            $medium = intval($medium / 8);
        }
        $data['point'] = compact('medium', 'list');

        // GET CARDS
        $keyCards = 'Cards_' . $this->user_id;
        $cards = $this->getCache($keyCards, true);
        if (!$cards) $cards = [];
        $data['cards'] = $cards;
        // GET CARDS

        // GET INFO ACCOUNT
        if (!empty($this->auth)) {
            $accountModel = new Account_model();
            $data['account'] = $accountModel->getInfoUserById($this->auth->user_id);
        }
        // GET INFO ACCOUNT

        $this->templates_assets = base_url() . 'public/game/list/';
        $data['turn'] = $turn;
        $data['type_lib'] = 'list';
        $data['main_content'] = $this->load->view($this->template_path . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function play()
    {
        
        //Check Turn Try
//        if ($turnTry == 3) {
//            if (empty($this->auth)) redirect('login?status=login_try_game');
//        }
        //Check Turn Try

        // GET REPORT POINT
        $reportModel = new Report_model();
        $points = $reportModel->getCountPointForType($this->user_id, '', 1);
        $medium = 0;
        $list = [];
        if (!empty($points)) {
            foreach ($points as $key => $point) {
                $count_point = (int)$point->point_dq;
                $medium += $count_point;
                $list[$point->task_type_point] = $count_point;
            }
            $medium = intval($medium / 8);
        }
        $data['point'] = compact('medium', 'list');
        // GET REPORT POINT

        // GET CARDS
        $keyCards = 'Cards_' . $this->user_id;
        $cards = $this->getCache($keyCards, true);
        if (!$cards) $cards = [];
        $data['cards'] = $cards;
        // GET CARDS

//        $data['step'] = 1;
        $data['type_lib'] = 'play';
        $data['main_content'] = $this->load->view($this->template_path . 'play', $data, TRUE);

        $this->load->view($this->template_main, $data);
    }

    public function review($key)
    {
        set_cookie('dq_review_game', $key, 60 * 60 * 24 * 30);

        // GET REPORT POINT
        $reportModel = new Report_model();
        $points = $reportModel->getCountPointForType($this->user_id, '', 1);
        $medium = 0;
        $list = [];
        if (!empty($points)) {
            foreach ($points as $key => $point) {
                $count_point = (int)$point->point_dq;
                $medium += $count_point;
                $list[$point->type] = $count_point;
            }
            $medium = intval($medium / 8);
        }
        $data['point'] = compact('medium', 'list');
        // GET REPORT POINT

        // GET CARDS
        $keyCards = 'Cards_' . $this->user_id;
        $cards = $this->getCache($keyCards, true);
        if (!$cards) $cards = [];
        $data['cards'] = $cards;
        // GET CARDS

        $data['type_lib'] = 'play';
        $data['is_review'] = true;
        $data['main_content'] = $this->load->view($this->template_path . 'play', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function training()
    {
        if (get_cookie('type_play') == 'try') {
            goto training;
        }

        if (!empty($this->auth)) {
            redirect(urlRoute('hocbai'));
        }

        training:
        $data['type_lib'] = 'play';
        $data['is_training'] = true;
        $data['main_content'] = $this->load->view($this->template_path . 'play', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
