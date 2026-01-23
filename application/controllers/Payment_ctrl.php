<?php

class Payment_ctrl extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->library('session');
        $this->load->model('User_mod');
        $this->load->model('Payment_mod');
        $this->load->model('Dashboard_mod');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/navbar');
        $this->load->view('user/payment');
        $this->load->view('templates/footer');
    }

    public function getData()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchValue = trim($this->input->post('search')['value']);

        $this->db->select("
            a.id,
            a.date_died,
            a.total_amt,
            a.amt_rcv,
            a.dead_line,
            a.status,
            b.hd_id,
            b.fname,
            b.mname,
            b.lname,
            b.phone1,
            b.phone2,
            CONCAT(b.fname, ' ', b.lname) AS full_name, 
            CONCAT_WS(', ', b.purok, b.barangay, b.city, b.province) AS address
        ");

        $this->db->from('tbl_deceased as a');
        $this->db->join('tbl_user_hd as b', 'b.hd_id = a.hd_id', 'left');

        // $this->db->where('a.status !=', 'settled');
        $this->db->order_by('a.date_died', 'DESC');

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('a.date_died', $searchValue);
            $this->db->or_like("CONCAT(b.fname, ' ', b.lname)",$searchValue,'both',false);
            $this->db->or_like("CONCAT_WS(', ', b.purok, b.barangay, b.city, b.province)",$searchValue,'both',false);
            $this->db->group_end();
        }

        $subQuery = clone $this->db;
        $recordsFiltered = $subQuery->get()->num_rows();

        $this->db->limit($length, $start);
        $query = $this->db->get();
        $data = $query->result_array();

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $recordsFiltered,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }

    public function get_mort_amt(){
        $this->db->select('mort_amt');
        $this->db->from('tbl_charge_info');
        $query = $this->db->get();
        $data = $query->result_array();
        echo json_encode([
            "status" => 'success',
            "data" => $data
            ]);
    }

    public function getHistory()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');

            $column_index = isset($order[0]['column']) ? $order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';

            $data = $this->Payment_mod->getData($start, $length, $column_index, $sort_direction, $search, true);

            $response = [
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
    }

    public function details()
    {
        $id = $this->input->post('id');

        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchValue = trim($this->input->post('search')['value']);

        $this->db->select("
            a.df_id,
            a.dd_id,
            a.amt,
            a.status,
            CONCAT(b.fname, ' ', b.lname) AS full_name
        ");

        $this->db->from('tbl_death_fund as a');
        $this->db->join('tbl_user_hd as b', 'b.hd_id = a.hd_id', 'left');
        $this->db->where('a.dd_id', $id);

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('fname', $searchValue);
            $this->db->or_like('lname', $searchValue);
            $this->db->or_like("CONCAT_WS(', ', purok, barangay, city, province)",$searchValue,'both',false);
            $this->db->or_like('phone1', $searchValue);
            $this->db->group_end();
        }

        $subQuery = clone $this->db;
        $recordsFiltered = $subQuery->get()->num_rows();

        $this->db->limit($length, $start);
        $query = $this->db->get();
        $data = $query->result_array();

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $recordsFiltered,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }

    public function payment_details()
    {
        $id = $this->input->post('id');

        $this->db->select("
            b.fullname,
            b.amt_rel,
            b.date_rel,
            a.total_amt,
            a.status
        ");
        
        $this->db->from('tbl_deceased as a');
        $this->db->join('tbl_released_fund as b', 'b.dd_id = a.id', 'left');
        $this->db->where('a.id', $id);

        $query = $this->db->get();
        $data = $query->result_array();

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "data" => $data
        ]);
    }


    public function updateDeathFund()
    {
        $df_id = $this->input->post('df_id');
        $dd_id = $this->input->post('dd_id');
        $amount = $this->input->post('amount');

        $this->db->set('amt', 'amt + ' . (int) $amount, FALSE);
        $this->db->set('status', 'paid');
        $this->db->where('df_id', $df_id);
        $this->db->update('tbl_death_fund');

        $this->db->select_sum('amt');
        $this->db->where('dd_id', $dd_id);
        $total_amt = $this->db->get('tbl_death_fund')->row()->amt;

        $this->db->where('id', $dd_id);
        $this->db->update('tbl_deceased', ['amt_rcv' => $total_amt]);

        $this->db->set('total_bal', 'total_bal + ' . (int) $amount, FALSE); 
        $this->db->update('tbl_charge_info');

        echo json_encode(['status' => 'success']);
    }

    public function updateReleaseFunds()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $date = $this->input->post('date');
            $name = $this->input->post('name');
            $type = $this->input->post('type');
            $amountRel = $this->input->post('amountRel');

            $this->db->set('id', $id);
            $this->db->set('r_date_returned', $date);
            // $this->db->set('r_rent_penalty', $penalty);
            // $this->db->set('r_total_amount', $totalAmount);
            // $this->db->set('r_damage_qty', $damageQty);
            // $this->db->set('r_damage_amount', $damageAmt);
            // $this->db->where('r_id', $id);
            $this->db->update('tbl_released_fund');

            // Get current ra_vacant_qty from rental_asset
            $this->db->select('ra_vacant_qty, ra_damage_qty');
            $this->db->from('rental_asset');
            // $this->db->where('id', $ra_id);
            $query = $this->db->get();
            $result = $query->row();

            if ($result) {
                // $finalQty = $quantity - $damageQty;
                // $newVacantQty = $result->ra_vacant_qty + $finalQty;
                // $newDamageQty = $result->ra_damage_qty + $damageQty;
                // Update rental_asset with new quantity
                // $this->db->set('ra_vacant_qty', $newVacantQty);
                // $this->db->set('ra_damage_qty', $newDamageQty);
                // $this->db->where('id', $ra_id);
                $this->db->update('rental_asset');


                // $this->db->set('bal', 'bal + ' . (int) $totalAmount, FALSE);
                // $this->db->set('rental_bal', 'rental_bal + ' . (int) $totalAmount, FALSE);
                $this->db->update('tbl_charge_info');;
            }

            echo json_encode(['status' => 'success']);
        } else {
            show_404();
        }
    }

    public function updateReleaseFund()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $date = $this->input->post('date');
            $name = $this->input->post('name');
            $type = $this->input->post('type');
            $amountRel = $this->input->post('amountRel');

            // var_dump($type);
            $data = [
                'dd_id' => $id,
                'fullname' => $name,
                'amt_rel' => $amountRel,
                'date_rel' => $date
            ];

            $this->db->insert('tbl_released_fund', $data);

            if ($type == "partial") {
                $this->db->set('status', 'partial');
                $this->db->where('id', $id);
                $this->db->update('tbl_deceased');
            } else {
                $this->db->set('status', 'settled');
                $this->db->where('id', $id);
                $this->db->update('tbl_deceased');
            }

            echo json_encode(['status' => 'success']);
        }
    }
}
