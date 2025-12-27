<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Play extends C19_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file'));
    }

    private function json_response($data, $status = 200)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($data));
    }

    public function index()
    {
        $USER_ID = $this->input->post('id');
        $key = "PLAY_OUT_$USER_ID";
        $time = $this->cache->get($key);
        if (!$time) $time = 0;
        
        if ($time >= 10) {
            return $this->json_response(['success' => 0, 'msg' => 'Bạn đã dành 45 phút để làm nhiệm vụ hôm nay!']);
        }
        $time++;
        $this->cache->save($key, $time, 86400); // 1 day
        
        return $this->json_response(['success' => 1]);
    }
}
