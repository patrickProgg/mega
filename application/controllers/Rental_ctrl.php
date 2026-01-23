<?php

class Rental_ctrl extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->library('session');
        $this->load->model('User_mod');
        $this->load->model('Payment_mod');
        $this->load->model('Dashboard_mod');
        $this->load->model('Rental_mod');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/navbar');
        $this->load->view('user/rental');
        $this->load->view('templates/footer');
    }

    public function getAssets()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchValue = trim($this->input->post('search')['value']);

        $this->db->select("
            id,
            desc,
            qty,
            vacant_qty,
            rent_period,
            std_amt,
            mem_amt,
            penalty_amt,
            damage_qty,
            damage_amt,
            date_purch,
            status
        ");

        $this->db->from('tbl_rental_asset');

        $this->db->order_by('id', 'DESC');

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

    public function getRenter()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchValue = trim($this->input->post('search')['value']);

        $this->db->select("
            a.id,
            a.full_name,
            a.ra_id,
            a.rent_qty,
            a.damage_qty,
            a.status,
            a.rent_date,
            a.due_date,
            a.date_returned,
            b.desc,
            b.qty,
            CASE
                WHEN a.type = 'member'
                    THEN a.rent_qty * b.mem_amt
                ELSE
                    a.rent_qty * b.std_amt
            END AS total_amt
        ");

        $this->db->from('tbl_renter as a');
        $this->db->join('tbl_rental_asset as b','b.id = a.ra_id','left');

        $this->db->order_by('id', 'DESC');

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('a.full_name', $searchValue);
            $this->db->or_like('b.desc', $searchValue);
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

    public function getIssuance()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchValue = trim($this->input->post('search')['value']);

        $this->db->select("
            a.*,
            b.desc,
            b.qty,
            CONCAT(c.fname, ' ', c.lname) AS full_name, 
        ");

        $this->db->from('tbl_supp_renter as a');
        $this->db->join('tbl_rental_asset as b','b.id = a.ra_id','left');
        $this->db->join('tbl_user_hd as c','c.hd_id = a.hd_id','left');

        $this->db->order_by('id', 'DESC');

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('a.full_name', $searchValue);
            $this->db->or_like('b.desc', $searchValue);
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

    public function get_rental_items()
    {
        $this->db->where('status', 'good');
        $query = $this->db->get('tbl_rental_asset');
        echo json_encode($query->result());
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

            $data = $this->Rental_mod->getRenter($start, $length, $column_index, $sort_direction, $search, true);

            $response = [

                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
    }

    public function getIssuanceHistory()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');

            $column_index = isset($order[0]['column']) ? $order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';

            $data = $this->Rental_mod->getIssuance($start, $length, $column_index, $sort_direction, $search, true);

            $response = [

                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
    }

    public function addAsset()
    {
        $data = $this->input->post();

        $assetData = [
            'desc' => $data['name'],
            'qty' => $data['qty'],
            'vacant_qty'  => $data['qty'],
            'rent_period'   => $data['period'],
            'std_amt'        => $data['std_rate'],
            'mem_amt'     => $data['mem_rate'],
            'penalty_amt'     => $data['pen_amt'],
            'damage_amt'      => $data['dam_amt'],
            'date_purch'      => $data['date_purch']
        ];

        $insert = $this->db->insert('tbl_rental_asset', $assetData);

        if ($insert) {
            echo json_encode(['success' => true, 'message' => 'Asset added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database insert failed']);
        }
    }

     public function updateAsset($id)
    {
        $data = $this->input->post();
       
        $updateAssetData = [
            'desc' => $data['name'],
            'qty' => $data['qty'],
            'vacant_qty'  => $data['qty'],
            'rent_period'   => $data['period'],
            'std_amt'        => $data['std_rate'],
            'mem_amt'     => $data['mem_rate'],
            'penalty_amt'     => $data['pen_amt'],
            'damage_amt'      => $data['dam_amt'],
            'date_purch'      => $data['date_purch']
        ];

        $this->db->where('id', $id);
        $update = $this->db->update('tbl_rental_asset', $updateAssetData);

        if ($update) {
            echo json_encode(['success' => true, 'message' => 'Asset updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
        }
    }

    public function assetDetails()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id');

            $data = $this->Rental_mod->getAsset($id);

            // var_dump($data);
            $response = array(
                "draw" => intval($this->input->post('draw')), // Required by DataTables
                "data" => $data
            );

            echo json_encode($response);
        } else {
            show_error('No direct access allowed');
        }
    }

    public function save_rental()
    {
        $rent_details = $this->input->post('rentals');
        $rentername  = $this->input->post('name');
        $date        = $this->input->post('date');
        $type        = $this->input->post('type');

        $this->db->trans_start(); // 🔒 start transaction

        foreach ($rent_details as $rental) {

            $rentPeriod = (int) $rental['rentPeriod'];
            $due_date   = date('Y-m-d', strtotime($date . " + {$rentPeriod} days"));

            $ra_id = $rental['rentedItemId'];
            $qty   = (int) $rental['quantity'];

            $available_qty = $this->Rental_mod->getAvailableQty($ra_id);

            if ($qty > $available_qty) {
                $this->db->trans_rollback();
                echo json_encode([
                    'success' => false,
                    'message' => 'Not enough stock for item: ' . $rental['rentedItem']
                ]);
                return;
            }

            $data = [
                'full_name' => $rentername,
                'ra_id'     => $ra_id,
                'rent_qty'  => $qty,
                'rent_date' => $date,
                'due_date'  => $due_date,
                'type'      => $type,
            ];

            $this->db->insert('tbl_renter', $data);

            $this->db->set('vacant_qty', "vacant_qty - {$qty}", false);
            $this->db->where('id', $ra_id);
            $this->db->update('tbl_rental_asset');
        }

        $this->db->trans_complete(); // ✅ end transaction

        if ($this->db->trans_status() === false) {
            echo json_encode(['success' => false, 'message' => 'Transaction failed']);
        } else {
            echo json_encode(['success' => true]);
        }
    }


    public function save_issuance()
    {
        if ($this->input->is_ajax_request()) {
            $issuance_details = $this->input->post('issuance'); // Get all rental items
            // $name = $this->input->post('name');
            $id = $this->input->post('id');
            $date = $this->input->post('date');

            if (!empty($issuance_details) && is_array($issuance_details)) {
                $insert_status = true; // Track insert success
                $error_message = ''; // Track error message

                foreach ($issuance_details as $issuance) {
                    $issuancePeriod = intval($issuance['Period']);
                    $due_date = date('Y-m-d', strtotime($date . " + $issuancePeriod days")); // Calculate due date

                    $qty = $issuance['Quantity'];
                    $ra_id = $issuance['ItemId'];

                    $available_qty = $this->Rental_mod->getAvailableQty($issuance['ItemId']);

                    if ($issuance['Quantity'] > $available_qty) {
                        echo json_encode(['success' => false, 'message' => "Not enough stock for item: " . $issuance['Item']]);
                        return; // Stop execution
                    }

                    $data = array(
                        'hd_id' => $id,
                        'ra_id' => $issuance['ItemId'],
                        'sr_rent_qty' => $issuance['Quantity'],
                        'sr_rent_date' => $date,
                        'sr_due_date' => $due_date,
                    );

                    $insert = $this->Rental_mod->insert_issuance($data);

                    if ($insert) {
                        $this->Rental_mod->updateItemQty($qty, $ra_id);
                    } else {
                        $insert_status = false;
                    }
                }

                if (!$insert_status && !empty($error_message)) {
                    echo json_encode(['success' => false, 'message' => $error_message]);
                } else {
                    echo json_encode(['success' => $insert_status]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'No rental data received.']);
            }
        }
    }

    public function getTotalAmount()
    {
        $id = $this->input->post('id');

        $this->db->select("
            a.*,
            b.*,
            a.status as rent_status,
            a.damage_qty as rent_damage_qty,
            CASE
                WHEN a.type = 'member'
                    THEN a.rent_qty * b.mem_amt
                ELSE
                    a.rent_qty * b.std_amt
            END AS total_amount
        ");

        $this->db->from('tbl_renter as a');
        $this->db->join('tbl_rental_asset as b','b.id = a.ra_id','left');
        $this->db->where('a.id', $id);

        $query = $this->db->get();
        $data = $query->result_array();

        echo json_encode([
            "status" => 'success',
            "data" => $data
        ]);
    }

    public function updateRenterStatus()
    {
        $id         = $this->input->post('id');
        $date       = $this->input->post('return_date');
        $totalAmount = (float) $this->input->post('total_amount');
        $quantity   = (int)   $this->input->post('quantity');
        $ra_id      = (int)   $this->input->post('ra_id');
        $damageAmt  = (float) $this->input->post('damageAmt');
        $damageQty  = (int)   $this->input->post('damageQty');

        $this->db->trans_start();

        $this->db->update('tbl_renter', [
            'status'        => 'paid',
            'date_returned' => $date,
            'total_amt'  => $totalAmount,
            'damage_qty'    => $damageQty,
        ], ['id' => $id]);

        $asset = $this->db->select('vacant_qty, damage_qty')
                        ->from('tbl_rental_asset')
                        ->where('id', $ra_id)
                        ->get()
                        ->row();

        if ($asset) {

            $finalQty      = $quantity - $damageQty;
            $newVacantQty  = $asset->vacant_qty + $finalQty;
            $newDamageQty  = $asset->damage_qty + $damageQty;

            $this->db->update('tbl_rental_asset', [
                'vacant_qty' => $newVacantQty,
                'damage_qty' => $newDamageQty
            ], ['id' => $ra_id]);

            $this->db->set('total_bal', 'total_bal + ' . $totalAmount, FALSE);
            $this->db->set('rental_bal', 'rental_bal + ' . $totalAmount, FALSE);
            $this->db->update('tbl_charge_info');
        }

        $this->db->trans_complete();

        echo json_encode(['status' => 'success']);
    }


    public function get_all_users()
    {
        $this->load->database();
        $query = $this->db->select("hd_id, CONCAT(fname, ' ', lname) AS full_name")
            ->from('tbl_user_hd')
            ->get();
        echo json_encode($query->result());
    }

}
