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
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');

            $column_index = isset($order[0]['column']) ? $order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';

            $data = $this->Payment_mod->getData($start, $length, $column_index, $sort_direction, $search);

            $response = [

                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
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
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $search = $this->input->post('search')['value'];

            $totalRecords = $this->Payment_mod->getTotalUserMembers($id);

            $data = $this->Payment_mod->getUserMember($id, $limit, $start, $search);
            $hd_id = $this->Payment_mod->getUserMemberId($id);

            $response = array(
                "draw" => intval($this->input->post('draw')), // Required by DataTables
                "recordsTotal" => $totalRecords, // Total records before filtering
                "recordsFiltered" => $totalRecords, // Total records after filtering
                "data" => $data,
                "hd_id" => $hd_id
            );

            echo json_encode($response);
        } else {
            show_error('No direct access allowed');
        }
    }

    public function payment_details()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');

            $data = $this->Payment_mod->getMemberDetails($id);
            $hd_id = $this->Payment_mod->getUserMemberId($id);

            $response = array(
                "draw" => intval($this->input->post('draw')),
                "data" => $data,
                "hd_id" => $hd_id
            );

            echo json_encode($response);
        } else {
            show_error('No direct access allowed');
        }
    }

    public function updateDeathFund()
    {
        if ($this->input->is_ajax_request()) {
            $df_id = $this->input->post('df_id');
            $dd_id = $this->input->post('dd_id');
            $amount = $this->input->post('amount');

            $this->db->set('amt', 'amt + ' . (int) $amount, FALSE);
            $this->db->set('status', 1);
            $this->db->where('df_id', $df_id);
            $this->db->update('death_fund');

            $this->db->select_sum('amt');
            $this->db->where('dd_id', $dd_id);
            $total_amt = $this->db->get('death_fund')->row()->amt;

            // Update deceased table with the total amount received
            $this->db->where('dd_id', $dd_id);
            $this->db->update('deceased', ['dd_amt_rcv' => $total_amt]);

            $this->db->set('bal', 'bal + ' . (int) $amount, FALSE); // Add the new amount to rem_bal
            $this->db->update('fund');

            echo json_encode(['status' => 'success']);
        } else {
            show_404();
        }
    }

    public function updateReleaseFunds()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $date = $this->input->post('date');
            $name = $this->input->post('name');
            $type = $this->input->post('type');
            $amountRel = $this->input->post('amountRel');

            $this->db->set('dd_id', $id);
            $this->db->set('r_date_returned', $date);
            // $this->db->set('r_rent_penalty', $penalty);
            // $this->db->set('r_total_amount', $totalAmount);
            // $this->db->set('r_damage_qty', $damageQty);
            // $this->db->set('r_damage_amount', $damageAmt);
            // $this->db->where('r_id', $id);
            $this->db->update('released_fund');

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
                $this->db->update('fund');;
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
                'rf_fullname' => $name,
                'rf_amt_rel' => $amountRel,
                'rf_date_rel' => $date,
                'dd_id' => $id,
            ];

            $this->db->insert('released_fund', $data);

            if ($type == "partial") {
                $this->db->set('dd_status', 1);
                $this->db->where('dd_id', $id);
                $this->db->update('deceased');
            } else {
                $this->db->set('dd_status', 2);
                $this->db->where('dd_id', $id);
                $this->db->update('deceased');
            }

            // Prepare data for insertion
            // $insertData = [];
            // foreach ($allUsers as $u) {
            //     // Check if entry already exists
            //     $exists = $this->db->get_where('death_fund', [
            //         'dd_id' => $dd_id,
            //         'hd_id' => $u->hd_id
            //     ])->row();

            //     if (!$exists) { // Only insert if not already in death_fund
            //         $insertData[] = [
            //             'dd_id' => $dd_id,
            //             'hd_id' => $u->hd_id,
            //             'amt' => 0,
            //             'status' => 0
            //         ];
            //     }
            // }

            // // Batch insert only if there are new records
            // if (!empty($insertData)) {
            //     $this->db->insert_batch('death_fund', $insertData);
            // }

            echo json_encode(['status' => 'success']);
        }
    }
}
