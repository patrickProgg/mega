<?php

class User_mod extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_csv_data($data)
    {
        if (!empty($data)) {
            return $this->db->insert_batch('user_hd', $data);
        }
        return false;
    }

    public function countData()
    {
        return $this->db->count_all("user_hd");
    }

    public function getAllActiveUsers()
    {
        $this->db->select("*");
        $this->db->from("user_hd");
        $this->db->where("status !=", 0);

        $query = $this->db->get();
        $data = $query->result_array();

        return [
            'total_records' => count($data),
            'data' => $data
        ];
    }

}
