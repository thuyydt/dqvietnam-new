<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Public_Controller
{
    const COLOR_1 = '#477ce6';
    const COLOR_2 = '#f7d155';
    const COLOR_3 = '#f2783d';
    const COLOR_4 = '#ee4646';

    const LABEL_1 = 'Quản lý thời gian tiếp xúc màn hình';
    const LABEL_2 = 'Quản lý bắt nạt trên mạng';
    const LABEL_3 = 'Quản lý quyền riêng tư';
    const LABEL_4 = 'Danh tính công dân ký thuật số';
    const LABEL_5 = 'Quản lý an ninh mạng';
    const LABEL_6 = 'Quản lý dấu chân kỹ thuật số';
    const LABEL_7 = 'Tư duy phản biện';
    const LABEL_8 = 'Cảm thông kỹ thuật số';

    public $_data;
    public $user_id;

    public function __construct()
    {
        parent::__construct();

        if (!empty($this->auth)) {
            $this->user_id = $this->auth->user_id;
        } else if (empty($this->auth) && $_COOKIE['dq_try_play']) {
            $this->user_id = $_COOKIE['dq_try_play'];
        } else {
            redirect('login');
            return;
        }

        $this->settings['meta_title'] = 'Báo Cáo';
        $this->load->model(['report_model', 'Point_model']);
        $this->_data = new Report_model();
        $this->template_path = 'public/report/';
        $this->template_main = $this->template_path . '_layout';
        $this->templates_assets = base_url() . 'public/report/';
    }

    public function index()
    {
        // GET REPORT POINT
        $reportModel = new Report_model();
        $points = $reportModel->getCountPointForType($this->user_id, '', 1);

        $medium = 0;
        $list = [];
        $chart = [];
        if (!empty($points)) {
            foreach ($points as $key => $point) {
                $count_point = (int)$point->point_dq;
                $medium += $count_point;
                $list[$point->task_type_point] = (object)[
                    'count_point' => $count_point,
                    'color' => $this->getColor($count_point)
                ];
                $chart[$point->task_type_point] = $count_point;
            }
            $medium = intval($medium / 8);
        }
        $data['point'] = compact('medium', 'list', 'chart');
        // GET REPORT POINT

        $data['medium'] = $medium;
        $data['list'] = $list;
        $data['color'] = $this->getColor($medium);
        $data['level'] = $this->getLevel($medium);
        $data['main_content'] = $this->load->view($this->template_path . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function detail($type)
    {
        if ($type <= 0 || $type > 8) redirect('report');
        $point = $this->_data->getCountPointForType($this->user_id, $type , true);
        if (empty($point)) {
            $point = (object) [];
            $point->count_point = 0;
        }
        $id = $this->user_id;
        $reportModel = new Report_model();
        $points = $reportModel->getCountPointForType($this->user_id, '', 1);
        $answerOne = $this->getKeyAnswer($id, '2', '3');
        $answerTwo = $this->getKeyAnswer($id, '12', 'A');
        $answerThree = $this->getKeyAnswer($id, '23', 'A');
        $answerFour = $this->getKeyAnswer($id, '32', 'A', 2);
        $answerFive = $this->getKeyAnswer($id, '50', '3', 1);
        $answerSix = $this->getKeyAnswer($id, '60', '3', 2);
        $answerSeven = $this->getKeyAnswer($id, '70', '3', 2);
        $answerEight = $this->getKeyAnswer($id, '72', '3');
        $data['answers'] = [
            '1' => $answerOne,
            '2' => $answerTwo,
            '3' => $answerThree,
            '4' => $answerFour,
            '5' => $answerFive,
            '6' => $answerSix,
            '7' => $answerSeven,
            '8' => $answerEight,
        ];

        if (!empty($points)) {
            foreach ($points as $point) {
                $count_point = (int)$point->point_dq;
                $list[$point->task_type_point] = $count_point;
            }
            $data['point_type'] = $list;
        }

        $data['type'] = $type;
        $data['title'] = $this->getLabel($type);
        $data['point'] = (int) $point->point_dq;
        $data['colorPoint'] = $this->getColor($data['point']);
        $data['level'] = $this->getLevel($data['point']);
        $data['main_content'] = $this->load->view($this->template_path . 'detail', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function getKeyAnswer($accountId, $key, $chose, $position = 0)
    {
        try {
            $reportModel = new Report_model();
            $answerOne = $reportModel->getAnswerByAccountId($accountId, $key);
            $question = $answerOne ? json_decode($answerOne->task) : false;
            $taskDetail = $question ? array_shift($question->task_detail) : false;
            if ($position > 0 && isset($question->task_detail[$position])) {
                $taskDetail = $question->task_detail[$position];
            }
            //$taskDetail = $question ? array_shift($question->task_detail) : false;
            $answers = $taskDetail ? json_decode($taskDetail->content, true) : false;
            return $answers['answers'][$chose] ?? '';
        } catch (\Exception $exception) {
            return '';
        }

    }


    private function getColor($point)
    {
        if ($point > 115) {
            $color = self::COLOR_1;
        }elseif ($point > 85) {
            $color = self::COLOR_2;
        }elseif ($point > 55) {
            $color = self::COLOR_3;
        }else {
            $color = self::COLOR_4;
        }
        return $color;
    }

    private function getLevel($point)
    {
        if ($point > 115) {
            $level = 1;
        }elseif ($point > 85) {
            $level = 2;
        }elseif ($point > 55) {
            $level = 3;
        }else {
            $level = 4;
        }
        return $level;
    }

    private function getLabel($type)
    {
        $title = '';
        switch ($type) {
            case 1:
                $title = self::LABEL_1;
                break;
            case 2:
                $title = self::LABEL_2;
                break;
            case 3:
                $title = self::LABEL_3;
                break;
            case 4:
                $title = self::LABEL_4;
                break;
            case 5:
                $title = self::LABEL_5;
                break;
            case 6:
                $title = self::LABEL_6;
                break;
            case 7:
                $title = self::LABEL_7;
                break;
            case 8:
                $title = self::LABEL_8;
                break;
        }
        return $title;
    }
}
