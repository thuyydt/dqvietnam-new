<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends API_Controller
{
    public $taskModel;
    public $packages_model;
    public $package_account_model;
    public $task_detail_model;
    public $point_model;
    public $report_model;
    private $info_package;
    private $task_current;
    private $account_model;
    private $account;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['task_model', 'packages_model', 'package_account_model', 'task_detail_model', 'point_model', 'report_model', 'Account_model']);
        $this->taskModel = new Task_model();
        $this->packages_model = new Packages_model();
        $this->package_account_model = new Package_account_model();
        $this->task_detail_model = new Task_detail_model();
        $this->point_model = new Point_model();
        $this->report_model = new Report_model();
        $this->account_model = new Account_model();

        $avatar = $this->user_auth->avatar ?? '';
        $this->account = [
            'avatar' => !empty($avatar) ? getImageThumb($avatar) : ''
        ];
    }

    public function getTasks()
    {
        $checkTaskCurrent = $this->getTaskCurrent();
        if (!$checkTaskCurrent) {
            $tasks = $this->taskModel->getTask();
        } else {
            $tasks = $this->taskModel->getTaskNext($this->task_current);
        }
        if (empty($tasks)) {
            $this->_message = [
                'code' => self::RESPONSE_NOT_EXIST,
                "message" => "Không có bài học nào."
            ];
            $this->returnJson($this->_message);
        }
        $tasks->task_detail = $this->task_detail_model->getTaskDetailByTaskId($tasks->id);

//        $key = 'TaskCurrent_'.$this->user_auth->id;
//        $setTaskCUrretn = $this->setCache($key, $tasks->id);

        $keyPoint = 'CountPoint_' . $this->user_auth->id;
        $countAllPoint = $this->getCache($keyPoint);
        if (!$countAllPoint) $countAllPoint = 0;

        $this->_message = [
            "code" => self::RESPONSE_SUCCESS,
            "message" => "Thông tin bài học",
            "data" => $tasks,
            "points" => $countAllPoint,
            "account" => $this->account
        ];
        $this->returnJson($this->_message);
    }

    public function getTaskNext()
    {
        $checkTaskCurrent = $this->getTaskCurrent();
        if (!$checkTaskCurrent) {
            $tasks = $this->taskModel->getTask();
        } else {
            $tasks = $this->taskModel->getTaskNext($this->task_current);
        }
        if (empty($tasks)) {
            $this->_message = [
                'code' => self::RESPONSE_NOT_EXIST,
                "message" => "Không có bài học nào."
            ];
            $this->returnJson($this->_message);
        }
        $tasks->task_detail = $this->task_detail_model->getTaskDetailByTaskId($tasks->id);

//        $key = 'TaskCurrent_'.$this->user_auth->id;
//        $setTaskCUrretn = $this->setCache($key, $tasks->id);

        $keyPoint = 'CountPoint_' . $this->user_auth->id;
        $countAllPoint = $this->getCache($keyPoint) ?? 0;

        $this->_message = [
            "code" => self::RESPONSE_SUCCESS,
            "message" => "Thông tin bài học",
            "data" => $tasks,
            "points" => $countAllPoint,
            "account" => $this->account
        ];
        $this->returnJson($this->_message);
    }

    public function reviewTask()
    {
        $inputJSON = file_get_contents('php://input');
        $request = json_decode($inputJSON, true);
        if (empty($request)) $request = $this->input->post();

        $this->report_model->table = $this->report_model->logs_play;
        $task = $this->report_model->getData([
            'table' => $this->report_model->logs_play,
            'where' => [
                'account_id' => $this->user_auth->id,
                'key' => $request['key']
            ],
            'order' => ['id' => 'DESC']
        ], 'row');

        if (empty($task)) {
            $this->_message = [
                "code" => self::RESPONSE_NOT_EXIST,
                "message" => "Lỗi"
            ];
            $this->returnJson($this->_message);
        }

        $keyPoint = 'CountPoint_' . $this->user_auth->id;
        $countAllPoint = $this->getCache($keyPoint);
        if (!$countAllPoint) $countAllPoint = 0;

        $this->_message = [
            "code" => self::RESPONSE_SUCCESS,
            "message" => "Thông tin bài học",
            "data" => $task,
            "points" => $countAllPoint,
            "account" => $this->account
        ];
        $this->returnJson($this->_message);
    }

    public function trainingTask()
    {
        $inputJSON = file_get_contents('php://input');
        $request = json_decode($inputJSON, true);
        if (empty($request)) $request = $this->input->post();

        $task_training = $this->task_detail_model->getTaskDetailTraining();

        $tasks = (object)[
            'name' => 'Trải nghiệm',
            'key' => 1,
            'id' => 0,
            'task_detail' => $task_training
        ];

        $this->_message = [
            "code" => self::RESPONSE_SUCCESS,
            "message" => "Thông tin bài học",
            "data" => $tasks,
            "points" => 0,
            "account" => $this->account
        ];
        $this->returnJson($this->_message);
    }

    public function saveTaskDone()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $inputJSON = file_get_contents('php://input');
            $request = json_decode($inputJSON, true);
            if (empty($request)) $request = $this->input->post();

            $countPoint = 0;
            if (!empty($request['points'])) foreach ($request['points'] as $id_task_detail => $point) {
                if (!(int)$point) continue;

                $task_detail = $this->task_detail_model->getById($id_task_detail);

                $countPoint += (int)$point;
                $this->point_model->save([
                    'account_id' => $this->user_auth->id,
                    'task_detail_id' => $task_detail->id,
                    'point' => $point,
                    'type' => $task_detail->type,
                    'task_type_point' => $task_detail->type_point,
                    'time_point' => date('Y-m-d H:i:s'),
                    'status' => 1
                ]);
            }

            $task = json_encode($request['task']);
            $answers = json_encode($request['answers']);

            if ($request['task']['key'] == 80) {
                $this->sendMail([
                    'title' => 'Báo cáo kết quả rủi ro trong không gian mạng',
                    'to' => $this->user_auth->username,
                    'template' => $this->load->view('admin/template_mail/task_done.php', [], true)
                ]);
                $this->account_model->setIsDone($this->user_auth->id);
            }

            $this->report_model->save([
                'account_id' => $this->user_auth->id,
                'task_id' => $request['task_id'],
                'task' => $task,
                'answer' => $answers,
                'key' => $request['task']['key']
            ], $this->report_model->logs_play);

            $key = 'TaskCurrent_' . $this->user_auth->id;
            $this->setCache($key, $request['task_id']);

            $keyPoint = 'CountPoint_' . $this->user_auth->id;
            $countAllPoint = (int)$this->getCache($keyPoint) ?? 0;
            $countAllPoint += $countPoint;
            $this->setCache($keyPoint, $countAllPoint);

            // Set cache chơi thứ game -> đến game thứ 3 phải check có tài khoản và thanh toán khoá học
            $keyTry = 'TryGame_' . $this->user_auth->id;
            $turnTry = $this->getCache($keyTry) ?? 0;
            if (!$turnTry) $turnTry = 0;
            $turnTry += 1;
            $this->setCache($keyTry, $turnTry);


            // Set cache Cards
            $keyCards = 'Cards_' . $this->user_auth->id;

            $cards = $this->getCache($keyCards, true);
            if (!$cards) $cards = [];
            $cards = array_merge($cards, $request['cards']);
            $this->setCache($keyCards, $cards);
            // Set cache Cards

            $this->_message = [
                "code" => self::RESPONSE_SUCCESS,
                "message" => "Thành công",
            ];
            $this->returnJson($this->_message);
        }
    }

    private function checkPackageAccount()
    {
        if ($this->user_auth->type == 1 && !empty($this->user_auth->schools_id)) {
            $account_package = $this->package_account_model->getInfoBySchoolId($this->user_auth->schools_id);
        } else {
            $account_package = $this->package_account_model->getInfoByAccountId($this->user_auth->id);
        }

        if (empty($account_package) || $account_package->status != 1) {
            $this->_message = [
                'code' => self::RESPONSE_NOT_EXIST,
                "message" => "Bạn chưa mua khóa học"
            ];
            $this->returnJson($this->_message);
        }

        $this->info_package = $this->packages_model->getById($account_package->package_id);
        if (empty($this->info_package)) {
            $this->_message = [
                'code' => self::RESPONSE_NOT_EXIST,
                "message" => "Khóa học không tồn tại, vui lòng kiểm tra lại."
            ];
            $this->returnJson($this->_message);
        }
    }

    private function getTaskCurrent()
    {
        $key = 'TaskCurrent_' . $this->user_auth->id;
        $this->task_current = $this->getCache($key);
        if (empty($this->task_current)) {
            return false;
        }
        return $this->task_current;
    }


}
