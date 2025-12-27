<?php

class Logs_action extends C19_mongo_model
{
    public function __construct()
    {
        parent::__construct();
        $this->colection = 'Logs_action';
    }

    public function insertLog($data = [], $campaign_id)
    {
        $data['created_time'] = date('Y-m-d H:i:s');
        if (!empty($campaign_id)) $this->colection .= '_' . $campaign_id;
        $result = $this->mongo->insert($this->colection,$data);
        return $result;
    }
}
