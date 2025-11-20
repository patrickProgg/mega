<?php

class Payment_mod extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getData($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search = null, $history = false)
    {
        $columns = ['dd_id', 'dd_full_name', 'dd_phone1', 'dd_total_amt', 'dd_status'];
        $sort_column = $columns[$column_index];

        $this->db->select("deceased.*, user_hd.*, CONCAT(user_hd.fname, ' ', user_hd.lname) AS full_name, CONCAT(user_hd.purok, ' ', user_hd.barangay, ' ', user_hd.city, ' ', user_hd.province) AS address");
        $this->db->from("deceased");
        $this->db->join('user_hd', 'user_hd.hd_id = deceased.hd_id', 'inner');
        $this->db->order_by('deceased.dd_date_died', 'DESC');

        if ($history) {
            $this->db->where('deceased.dd_status', 2);
        } else {
            $this->db->where('deceased.dd_status!=', 2);
        }

        if (!empty($search)) {
            $this->db->group_start();

            // Remove non-numeric characters for ID search
            $numericSearch = preg_replace('/\D/', '', $search);
            if (!empty($numericSearch)) {
                $this->db->or_like('dd_id', $numericSearch);
                $this->db->or_like('dd_phone1', $numericSearch);
            }

            // Name search (first name, last name, and full name)
            $this->db->or_like('dd_fname', $search);
            $this->db->or_like('dd_lname', $search);
            $this->db->or_like("CONCAT(dd_fname, ' ', dd_lname)", $search, FALSE);

            // Address search
            $this->db->or_like('dd_purok', $search);
            $this->db->or_like('dd_barangay', $search);
            $this->db->or_like('dd_city', $search);
            $this->db->or_like('dd_province', $search);

            // Date search (if input is a valid date)
            if (strtotime($search)) {
                $dateFormatted = date('Y-m-d', strtotime($search));
                $this->db->or_like('dd_date', $dateFormatted);
            }

            $this->db->group_end();
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
            'total_records' => $this->db->count_all('deceased'),
            'filtered_records' => $filtered_records,
            'data' => $data
        ];
    }

    public function getUserMember($id, $limit = 10, $start = 0, $search = '')
    {
        // $this->db->select("user_hd.*,death_fund.*,deceased.*, CONCAT(user_hd.fname, ' ', user_hd.lname) AS hd_full_name");
        // $this->db->from('death_fund');
        // $this->db->join('user_hd', 'user_hd.hd_id = death_fund.hd_id', 'inner');
        // $this->db->join('deceased', 'deceased.dd_id = death_fund.dd_id', 'inner'); 
        // $this->db->where('death_fund.dd_id', $id);

        $this->db->select("user_hd.*,death_fund.*,deceased.*, CONCAT(user_hd.fname, ' ', user_hd.lname) AS hd_full_name");
        $this->db->from('deceased');
        $this->db->join('death_fund', 'death_fund.dd_id = deceased.dd_id', 'inner');
        $this->db->join('user_hd', 'user_hd.hd_id = death_fund.hd_id', 'inner');
        $this->db->where('death_fund.dd_id', $id);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('user_hd.fname', $search);
            $this->db->or_like('user_hd.lname', $search);
            $this->db->or_like('user_hd.city', $search);
            $this->db->or_like('user_hd.province', $search);
            $this->db->group_end();
        }

        $this->db->limit($limit, $start);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getUserMemberId($id)
    {
        $this->db->select("CONCAT(user_hd.fname, ' ', user_hd.lname) AS hd_full_name, deceased.*");
        $this->db->from('deceased');
        $this->db->join('user_hd', 'user_hd.hd_id = deceased.hd_id', 'inner');
        $this->db->where('deceased.dd_id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function getMemberDetails($id)
    {
        $this->db->select("deceased.*, released_fund.*");
        $this->db->from('deceased');
        $this->db->join('released_fund', 'released_fund.dd_id = deceased.dd_id', 'inner');
        // $this->db->join('user_ln', 'user_ln.ln_id = released_fund.ln_id', 'inner');
        $this->db->where('deceased.dd_id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTotalUserMembers($id, $search = '')
    {
        $this->db->from('death_fund');
        $this->db->join('user_hd', 'user_hd.hd_id = death_fund.hd_id', 'inner');
        $this->db->where('death_fund.dd_id', $id);

        // Apply search filter if provided
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('user_hd.fname', $search);
            $this->db->or_like('user_hd.lname', $search);
            $this->db->or_like('user_hd.city', $search);
            $this->db->or_like('user_hd.province', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }
}
