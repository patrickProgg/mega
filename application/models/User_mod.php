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

    public function getData($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search = null, $status = null, $address = null)
    {
        $columns = ['hd_id', 'full_name', 'address', 'phone1', 'status'];
        $sort_column = $columns[$column_index];

        $this->db->select("user_hd.*, 
        CONCAT(fname, ' ', lname) AS full_name, 
        CONCAT_WS(', ', purok, barangay, city, province) AS address");
        $this->db->from("user_hd");
        $this->db->order_by("hd_id", 'DESC');

        if (!empty($search)) {
            $this->db->group_start();

            // Remove non-numeric characters for ID search
            $numericSearch = preg_replace('/\D/', '', $search);
            if (!empty($numericSearch)) {
                $this->db->or_like('hd_id', $numericSearch);
                $this->db->or_like('phone1', $numericSearch);
            }

            // Name search (first name, last name, and full name)
            $this->db->or_like('fname', $search);
            $this->db->or_like('lname', $search);
            $this->db->or_like("CONCAT(fname, ' ', lname)", $search, FALSE);

            // Address search
            $this->db->or_like('purok', $search);
            $this->db->or_like('barangay', $search);
            $this->db->or_like('city', $search);
            $this->db->or_like('province', $search);

            // Date search (if input is a valid date)
            if (strtotime($search)) {
                $dateFormatted = date('Y-m-d', strtotime($search));
                $this->db->or_like('date', $dateFormatted);
            }

            $this->db->group_end();
        }

        if (!empty($status)) {
            $this->db->where('status', $status);
        }

        if (!empty($address)) {
            $this->db->group_start()
                ->like('purok', $address)
                ->or_like('barangay', $address)
                ->or_like('city', $address)
                ->group_end();
        }

        // Clone query before applying limit and sorting for `filtered_records`
        $clone_db = clone $this->db;
        $filtered_records = $clone_db->count_all_results();

        // Apply sorting and limit
        $this->db->order_by($sort_column, $sort_direction);
        $this->db->limit($length, $start);

        // Execute the query
        $query = $this->db->get();
        $data = $query->result_array();

        return [
            'total_records' => $this->db->count_all('user_hd'),
            'filtered_records' => $filtered_records,
            'data' => $data
        ];
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

    // public function getUserMemberDetails($id)
    // {
    //     $this->db->select("
    //     user_hd.*, 
    //     user_hd.hd_id AS header_id, 
    //     CONCAT(user_hd.fname, ' ', user_hd.lname) AS full_name,
    //     user_ln.*, 
    //     user_ln.status AS ul_status, 
    //     CONCAT(user_ln.fname, ' ', user_ln.lname) AS ul_full_name, 
    //     CONCAT(user_ln.purok, ' ', user_ln.barangay, ' ', user_ln.city, ' ', user_ln.province) AS address
    // ");
    //     $this->db->from('user_hd');
    //     $this->db->join('user_ln', 'user_ln.hd_id = user_hd.hd_id', 'left');
    //     $this->db->where('user_hd.hd_id', $id);

    //     $query = $this->db->get();
    //     return $query->result_array();
    // }


    public function getUserMember($id)
    {
        $this->db->select("user_ln.*, user_ln.status AS ul_status, CONCAT(user_ln.fname, ' ', user_ln.lname) AS ul_full_name, CONCAT(user_hd.fname, ' ', user_hd.lname) AS full_name, CONCAT_WS(', ', user_ln.purok, user_ln.barangay, user_ln.city, user_ln.province) AS address");
        $this->db->from('user_ln');
        $this->db->join('user_hd', 'user_hd.hd_id = user_ln.hd_id', 'left');
        $this->db->where('user_ln.hd_id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getUserMemberId($id)
    {
        $this->db->select("user_hd.*,user_hd.hd_id AS header_id, CONCAT(user_hd.fname, ' ', user_hd.lname) as fullname");
        $this->db->from('user_hd');
        $this->db->where('user_hd.hd_id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getMember($id)
    {
        $this->db->select("user_hd.*, CONCAT(user_hd.fname, ' ', user_hd.lname) AS full_name");
        $this->db->from('user_hd');
        $this->db->where('hd_id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getFamMember($id)
    {
        $this->db->select("user_ln.*, CONCAT(fname, ' ', lname) AS full_name");
        $this->db->from('user_ln');
        $this->db->where('ln_id', $id);

        $query = $this->db->get();
        // var_dump($query);
        return $query->result_array();
    }
}
