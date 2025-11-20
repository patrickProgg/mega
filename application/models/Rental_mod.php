<?php

class Rental_mod extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAssets($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search = null)
    {
        $columns = ['id', 'ra_desc', 'ra_qty', 'ra_amount', 'ra_date_purch', 'ra_status'];
        $sort_column = $columns[$column_index];

        $this->db->select("*");
        $this->db->from("rental_asset");

        if (!empty($search)) {
            $this->db->group_start();

            // Remove non-numeric characters for numeric searches
            $numericSearch = preg_replace('/\D/', '', $search);
            if (!empty($numericSearch)) {
                $this->db->or_like('id', $numericSearch);
                $this->db->or_like('ra_qty', $numericSearch);
                $this->db->or_like('ra_amount', $numericSearch);
            }

            $this->db->or_like('ra_desc', $search);
            $this->db->or_like('ra_status', $search);

            // Search for valid date inputs
            if (strtotime($search)) {
                $dateFormatted = date('Y-m-d', strtotime($search));
                $this->db->or_like('ra_date_purch', $dateFormatted);
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
            'total_records' => $this->db->count_all('rental_asset'),
            'filtered_records' => $filtered_records,
            'data' => $data
        ];
    }

    public function getRenter($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search = null, $history = false)
    {
        $columns = ['r_name', 'ra_desc', 'r_rent_qty', 'r_rent_date', 'r_due_date', 'r_date_returned', 'r_amount', 'r_rent_penalty', 'r_total_amount', 'r_status'];
        $sort_column = $columns[$column_index];

        $this->db->select("renter.*, rental_asset.*");
        $this->db->from("renter");
        $this->db->join('rental_asset', 'rental_asset.id = renter.ra_id', 'inner');
        $this->db->order_by('renter.r_id', 'DESC');

        if ($history) {
            $this->db->where('renter.r_status', 1);
        } else {
            $this->db->where('renter.r_status', 0);
        }

        if (!empty($search)) {
            $numericSearch = preg_replace('/\D/', '', $search);

            $this->db->group_start();
            $this->db->like('r_name', $search);
            $this->db->or_like('ra_desc', $search);
            $this->db->or_like('r_rent_qty', $search);
            $this->db->or_like('r_amount', $search);
            $this->db->or_like('r_rent_date', $search);

            if (strtotime($search)) { // Only apply if $search is a valid date
                $dateFormatted = date('Y-m-d', strtotime($search));
                $this->db->or_like('r_due_date', $dateFormatted);
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
        // var_dump($data);

        return [
            'total_records' => $this->db->count_all('renter'),
            'filtered_records' => $filtered_records,
            'data' => $data
        ];
    }

    public function getIssuance($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search = null, $history = false)
    {
        $columns = [
            'full_name',
            'ra_desc',
            'sr_rent_qty',
            'sr_rent_date',
            'sr_due_date',
            'sr_date_returned',
            'sr_rent_penalty',
            'sr_total_amount',
            'sr_status'
        ];

        $sort_column = $columns[$column_index];
        // $this->db->select("supp_renter.*, CONCAT(sr_status_1, ' ', sr_status_2) AS status, user_hd.hd_id AS user_hd_id, CONCAT(user_hd.fname, ' ', user_hd.lname) AS full_name, rental_asset.*");
        $this->db->select("supp_renter.*, user_hd.hd_id AS user_hd_id, CONCAT(user_hd.fname, ' ', user_hd.lname) AS full_name, rental_asset.*");
        $this->db->from("supp_renter");
        $this->db->join('user_hd', 'supp_renter.hd_id = user_hd.hd_id', 'inner');
        $this->db->join('rental_asset', 'supp_renter.ra_id = rental_asset.id', 'inner');
        $this->db->order_by('supp_renter.sr_id', 'DESC');

        if ($history) {
            $this->db->where('supp_renter.sr_status_1', 1);
        } else {
            $this->db->where('supp_renter.sr_status_1', 0);
        }

        if (!empty($search)) {
            $numericSearch = preg_replace('/\D/', '', $search);

            $this->db->group_start();
            $this->db->like('user_hd.fname', $search);
            $this->db->or_like('user_hd.lname', $search);
            $this->db->or_like("CONCAT(user_hd.fname, ' ', user_hd.lname)", $search, 'both');
            $this->db->or_like('rental_asset.ra_desc', $search);
            $this->db->or_like('supp_renter.sr_rent_qty', $search);
            $this->db->or_like('supp_renter.sr_total_amount', $search);
            $this->db->or_like('supp_renter.sr_rent_date', $search);

            if (strtotime($search)) {
                $dateFormatted = date('Y-m-d', strtotime($search));
                $this->db->or_like('supp_renter.sr_due_date', $dateFormatted);
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
        // var_dump($data);

        return [
            'total_records' => $this->db->count_all('supp_renter'),
            'filtered_records' => $filtered_records,
            'data' => $data
        ];
    }

    public function getAvailableQty($ra_id)
    {
        $this->db->select('ra_vacant_qty');
        $this->db->where('id', $ra_id);
        $query = $this->db->get('rental_asset'); // Adjust table name if needed

        if ($query->num_rows() > 0) {
            return $query->row()->ra_vacant_qty; // Return available quantity
        }
        return 0; // Return 0 if not found
    }

    public function insert_rental($data)
    {
        return $this->db->insert('renter', $data);
    }

    public function updateItemQty($qty, $ra_id)
    {
        $this->db->set('ra_vacant_qty', 'ra_vacant_qty - ' . intval($qty), FALSE);
        $this->db->where('id', $ra_id);
        return $this->db->update('rental_asset');
    }

    public function getTotalAmountById($r_id)
    {
        $this->db->select('r_amount');
        $this->db->from('renter');
        $this->db->where('r_id', $r_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->r_amount;
        } else {
            return null;
        }
    }

    public function insert_issuance($data)
    {
        return $this->db->insert('supp_renter', $data);
    }

    public function getAsset($id)
    {
        // $this->db->select("user_ln.*, CONCAT(fname, ' ', lname) AS full_name");
        $this->db->from('rental_asset');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }
}
