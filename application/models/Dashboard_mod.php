<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_mod extends CI_Model
{
    public function get_totals()
    {
        $this->db->select("user_hd.*, CONCAT(fname, ' ', lname) AS full_name");
        $this->db->from('user_hd');
        $this->db->order_by('hd_id', 'DESC'); // Sort by latest entry (assuming `hd_id` is auto-increment)
        // $this->db->order_by('created_at', 'DESC');
        $this->db->limit(7); // Get only the latest 5 records

        $query = $this->db->get();
        $data = $query->result_array();

        return [
            'total_members' => $this->db->count_all('user_hd'),
            'data' => $data
        ];
    }

    public function total_late_members()
    {
        $this->db->select("deceased.*, CONCAT(user_hd.fname, ' ', user_hd.lname) AS full_name");
        $this->db->from('deceased');
        $this->db->join('user_hd', 'user_hd.hd_id = deceased.hd_id', 'inner');
        $this->db->where('deceased.dd_status !=', 2);
        $this->db->order_by('dd_id', 'DESC');
        $this->db->limit(7);

        $query = $this->db->get();
        $data = $query->result_array();

        return [
            'total_late_members' => $this->db->count_all('deceased'),
            'data' => $data
        ];
    }

    public function total_fund()
    {
        $this->db->select("bal,rental_bal");
        $this->db->from('fund');
        $query = $this->db->get()->row();

        return [
            'total_fund' => $query ? $query->bal : 0,
            'total_rent_revenue' => $query ? $query->rental_bal : 0 
        ];
    }

}
    