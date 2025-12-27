<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report extends Admin_Controller
{
    protected $_data;
    protected $_data_schools;
    protected $_data_report;
    protected $_name_controller;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('account_model', 'Schools_model', 'report_model'));
        $this->_data = new Account_model();
        $this->_data_schools = new Schools_model();
        $this->_data_report = new Report_model();
        $this->_name_controller = $this->router->fetch_class();
    }

    public function index()
    {
        $data['heading_title'] = 'Báo cáo';
        $data['heading_description'] = "Báo cáo chi tiết học viên";
        /*Breadcrumbs*/
        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($data['heading_title'], '#');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $data['main_content'] = $this->load->view($this->template_path . 'report/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function ajax_list()
    {
        $this->checkRequestPostAjax();

        $length = $this->input->post('length');
        $start = $this->input->post('start');
        $page =  $start / $length + 1;
        $limit = $length;

        $school_id = 0;
        if ( !empty( $this->session->school_id ) ) {
            $school_id = $this->session->school_id;
        } elseif (!empty( $this->input->get('filter_school') )) {
            $school_id = $this->input->post('filter_school');
        }

        $list = $this->_data_report->getDataAccountLever4($school_id, $page, $limit);

        $data = array();
        if (!empty($list)) foreach ($list as $item) {
            $row = array();
            $row[] = $item->account_id;
            $row[] = showCenter($item->account_id);
            $row[] = $item->username;
            $row[] = intval($item->point_medium);
            $row[] = button_action($item->account_id, ['view_point']);
            $data[] = $row;
        }

        $total = $this->_data_report->getDataAccountLever4($school_id, null);
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data,
        );
        $this->returnJson($output);
    }

    public function ajax_parameters_report()
    {
        $params = [
            'active' => 1
        ];

        $school_id = 0;

        if ( !empty( $this->session->school_id ) ) {
            $params['where'] = [
                'schools_id' => $this->session->school_id
            ];
            $school_id = $this->session->school_id;
        } elseif (!empty( $this->input->get('filter_school') )) {
            $params['where'] = [
                'schools_id' => $this->input->get('filter_school')
            ];
            $school_id = $this->input->post('filter_school');
        }

        $total_account = $this->_data->getTotal($params);

        $where = isset($params['where']) && is_array($params['where']) ? $params['where'] : [];
        $params['where'] = array_merge($where, ['is_done' => 1]);

        $total_account_done = $this->_data->getTotal($params);

        $output['total_account'] = $total_account;
        $output['total_account_done'] = $total_account_done;
        $output['total_account_doing'] = $total_account - $total_account_done;
        $output['total_medium'] = 0;

        if ($total_account_done) {
            $total_point = $this->_data_report->getCountPointForAccountDone($school_id);
            $output['total_medium'] = round((int) $total_point / $total_account_done, 2);
        }

        echo json_encode($output);
        exit;
    }

    public function ajax_percent_of_levels() {

        $school_id = 0;

        if ( !empty( $this->session->school_id ) ) {
            $params['where'] = [
                'schools_id' => $this->session->school_id
            ];
            $school_id = $this->session->school_id;
        } elseif (!empty( $this->input->get('filter_school') )) {
            $params['where'] = [
                'schools_id' => $this->input->get('filter_school')
            ];
            $school_id = $this->input->post('filter_school');
        }

        $data = $this->_data_report->getPointForAccountDone($school_id);

        $total = 0;
        $res = [
            1 => [
                'total' => 0,
                'percent' => 0,
            ],
            2 => [
                'total' => 0,
                'percent' => 0,
            ],
            3 => [
                'total' => 0,
                'percent' => 0,
            ],
            4 => [
                'total' => 0,
                'percent' => 0,
            ]
        ];

        if (!empty($data)) foreach ($data as $item) {
            $total += 1;
            $point = (int)$item->point_medium;
            if ($point >= 150) {
                $res[1]['total'] += 1;
            }
            else if ($point >= 100) {
                $res[2]['total'] += 1;
            }
            else if ($point >= 88) {
                $res[3]['total'] += 1;
            }
            else {
                $res[4]['total'] += 1;
            }
        }

        if ($total > 0) {
            foreach ($res as $key => $value) {
                $res[$key]['percent'] = round(($value['total'] / $total) * 100, 2);
            }
        }

        echo json_encode($res);
        exit;
    }
}
