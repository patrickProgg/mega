<?php

class Payment_mod extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getData($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search = null, $history = false)
    {
        $columns = ['id', 'full_name', 'phone1', 'total_amt', 'status'];
        $sort_column = $columns[$column_index];

        $this->db->select("deceased.*, user_hd.*, CONCAT(user_hd.fname, ' ', user_hd.lname) AS full_name, CONCAT(user_hd.purok, ' ', user_hd.barangay, ' ', user_hd.city, ' ', user_hd.province) AS address");
        $this->db->from("deceased");
        $this->db->join('user_hd', 'user_hd.hd_id = deceased.hd_id', 'inner');
        $this->db->order_by('deceased.date_died', 'DESC');

        if ($history) {
            $this->db->where('deceased.status', 2);
        } else {
            $this->db->where('deceased.status!=', 2);
        }

        if (!empty($search)) {
            $this->db->group_start();

            // Remove non-numeric characters for ID search
            $numericSearch = preg_replace('/\D/', '', $search);
            if (!empty($numericSearch)) {
                $this->db->or_like('id', $numericSearch);
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

}
