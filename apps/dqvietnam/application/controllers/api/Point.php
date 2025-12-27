<?php
/**
 * Created by PhpStorm.
 * User: doan_du
 * Date: 08/05/2022
 * Time: 10:22
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Point extends API_Controller
{
    public $point_model;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['point_model']);
        $this->point_model = new Point_model();

    }

    public function log_point() {
        $inputJSON = file_get_contents('php://input');
        $request = json_decode($inputJSON,true);
        if (empty($request)) $request = $this->input->post();

        if(empty($request['task_detail']) || empty($request['point']) || $request['point'] < 0) {
            $this->_message = [
                'code' => self::RESPONSE_NOT_EXIST,
                "message" => "Vui lòng điền đầy đủ thông tin"
            ];
            $this->returnJson($this->_message);
        }

        $checkExistPoint = $this->point_model->checkExistLogsPointByAccTask($this->user_auth->id, $request['task_detail']);
        if(!empty($checkExistPoint)) {
            $this->_message = [
                'code' => self::RESPONSE_SUCCESS,
                "message" => "Thêm điểm thành công"
            ];
            $this->returnJson($this->_message);
        }

        $dataLog = [
            'account_id' => $this->user_auth->id,
            'task_detail_id' => $request['task_detail'],
            'point' => $request['point'],
            'time_point' => date('Y-m-d H:i:s'),
            'status' => 1
        ];

        $insertLog = $this->point_model->save($dataLog);
        if($insertLog) {
            $this->_message = [
                'code' => self::RESPONSE_SUCCESS,
                'point' => $request['point'],
                "message" => "Thêm điểm thành công"
            ];
            $this->returnJson($this->_message);
        } else {
            $this->_message = [
                'code' => self::RESPONSE_SERVER_ERROR,
                "message" => "Thêm điểm thất bại"
            ];
            $this->returnJson($this->_message);
        }

    }




}