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
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');

            $column_index = isset($order[0]['column']) ? $order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';

            $data = $this->Rental_mod->getAssets($start, $length, $column_index, $sort_direction, $search);

            $response = [
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
    }

    public function getRenter()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');

            $column_index = isset($order[0]['column']) ? $order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';

            $data = $this->Rental_mod->getRenter($start, $length, $column_index, $sort_direction, $search);

            $response = [
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
    }

    public function getIssuance()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');

            $column_index = isset($order[0]['column']) ? $order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';

            $data = $this->Rental_mod->getIssuance($start, $length, $column_index, $sort_direction, $search);

            $response = [

                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
    }

    public function get_rental_items()
    {
        $this->db->where('ra_status', 1);
        $query = $this->db->get('rental_asset');
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
        if ($this->input->is_ajax_request()) {

            $data = $this->input->post();

            $assetData = [
                'ra_desc' => $data['asset'],
                'ra_qty' => $data['qty'],
                'ra_vacant_qty'  => $data['qty'],
                'ra_rent_period'   => $data['rentPeriod'],
                'ra_amount'        => $data['nonMemAmt'],
                'ra_amount_member'     => $data['memAmt'],
                'ra_penalty_amount'     => $data['penAmt'],
                'ra_damage_qty'      => 0,
                'ra_damage_amount'      => $data['damAmt'],
                'ra_date_purch'      => $data['datePurch'],
                'ra_status'      => 0,
            ];

            // Insert into database
            $insert = $this->db->insert('rental_asset', $assetData);

            if ($insert) {
                echo json_encode(['success' => true, 'message' => 'Asset added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database insert failed']);
            }
        } else {
            show_error('No direct access allowed');
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
        if ($this->input->is_ajax_request()) {
            $rent_details = $this->input->post('rentals'); // Get all rental items
            $rentername = $this->input->post('name');
            $date = $this->input->post('date');
            // $dateNow = date('Y-m-d'); // Format: YYYY-MM-DD

            if (!empty($rent_details) && is_array($rent_details)) {
                $insert_status = true; // Track insert success
                $error_message = ''; // Track error message

                foreach ($rent_details as $rental) {
                    $rentPeriod = intval($rental['rentPeriod']); // Convert rent period to integer
                    $due_date = date('Y-m-d', strtotime($date . " + $rentPeriod days")); // Calculate due date

                    $available_qty = $this->Rental_mod->getAvailableQty($rental['rentedItemId']);

                    $qty = $rental['quantity'];
                    $ra_id = $rental['rentedItemId'];


                    if ($rental['quantity'] > $available_qty) {
                        echo json_encode(['success' => false, 'message' => "Not enough stock for item: " . $rental['rentedItem']]);
                        return; // Stop execution
                    }

                    $data = array(
                        'r_name' => $rentername,
                        'ra_id' => $rental['rentedItemId'], // Use rental array data
                        'r_rent_qty' => $rental['quantity'],
                        'r_amount' => $rental['totalAmount'],
                        'r_rent_date' => $date,
                        'r_due_date' => $due_date,
                    );

                    $insert = $this->Rental_mod->insert_rental($data);

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

    // public function getTotalAmount()
    // {
    //     $r_id = $this->input->post('id');

    //     $totalAmount = $this->Rental_mod->getTotalAmountById($r_id);

    //     if ($totalAmount !== null) {
    //         echo json_encode(['status' => 'success', 'total_amount' => $totalAmount]);
    //     } else {
    //         echo json_encode(['status' => 'error']);
    //     }
    // }

    public function getTotalAmount()
    {
        $id = $this->input->post('id');

        $rental = $this->db->select('renter.*, rental_asset.*')
            ->from('renter')
            ->join('rental_asset', 'renter.ra_id = rental_asset.id', 'inner')
            ->where('renter.r_id', $id)
            ->get()
            ->row(); // Fetch the result row

        if (!$rental) {
            echo json_encode(['status' => 'error', 'message' => 'Rental not found.']);
            return;
        }

        echo json_encode([
            'status' => 'success',
            'name' => $rental->r_name,
            'item' => $rental->ra_desc,
            'damageAmt' => $rental->ra_damage_amount,
            'rent_qty' => $rental->r_rent_qty,
            'total_amount' => $rental->r_amount,
            'due_date' => $rental->r_due_date,
            'penalty_amount' => $rental->ra_penalty_amount,
            'rent_period' => $rental->ra_rent_period
        ]);
    }

    public function updateRenterStatus()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $date = $this->input->post('date');
            $penalty = $this->input->post('penalty');
            $totalAmount = $this->input->post('total_amount');
            $amount = $this->input->post('amount');
            $quantity = $this->input->post('quantity');
            $ra_id = $this->input->post('ra_id'); // Get rental asset ID
            $damageAmt = $this->input->post('damageAmt');
            $damageQty = $this->input->post('damageQty');

            // var_dump($quantity);
            // var_dump($damageQty);
            // exit;

            $penaltyAmt = $totalAmount - $amount;

            // Update renter details
            $this->db->set('r_status', 1);
            $this->db->set('r_date_returned', $date);
            // $this->db->set('r_rent_penalty', $penalty);
            $this->db->set('r_rent_penalty', $penaltyAmt);
            $this->db->set('r_total_amount', $totalAmount);
            $this->db->set('r_damage_qty', $damageQty);
            $this->db->set('r_damage_amount', $damageAmt);
            $this->db->where('r_id', $id);
            $this->db->update('renter');

            // Get current ra_vacant_qty from rental_asset
            $this->db->select('ra_vacant_qty, ra_damage_qty');
            $this->db->from('rental_asset');
            $this->db->where('id', $ra_id);
            $query = $this->db->get();
            $result = $query->row();

            if ($result) {
                $finalQty = $quantity - $damageQty;
                $newVacantQty = $result->ra_vacant_qty + $finalQty;
                $newDamageQty = $result->ra_damage_qty + $damageQty;
                // Update rental_asset with new quantity
                $this->db->set('ra_vacant_qty', $newVacantQty);
                $this->db->set('ra_damage_qty', $newDamageQty);
                $this->db->where('id', $ra_id);
                $this->db->update('rental_asset');

                $this->db->set('bal', 'bal + ' . (int) $totalAmount, FALSE);
                $this->db->set('rental_bal', 'rental_bal + ' . (int) $totalAmount, FALSE);
                $this->db->update('fund');
            }

            echo json_encode(['status' => 'success']);
        } else {
            show_404();
        }
    }

    public function get_all_users()
    {
        $this->load->database();
        $query = $this->db->select("hd_id, CONCAT(fname, ' ', lname) AS full_name")
            ->from('user_hd')
            ->get();
        echo json_encode($query->result());
    }

    public function updateAsset()
    {
        if ($this->input->is_ajax_request()) {

            $data = $this->input->post();
            $id = $data['id'];
            $newQty = (int) $data['eqty'];

            $existing = $this->db->select('ra_qty, ra_vacant_qty')
                ->from('rental_asset')
                ->where('id', $id)
                ->get()
                ->row();

            if (!$existing) {
                echo json_encode(['success' => false, 'message' => 'Asset not found']);
                return;
            }

            $oldQty = (int) $existing->ra_qty;
            $vacantQty = (int) $existing->ra_vacant_qty;

            $qtyDifference = $newQty - $oldQty;

            $assetData = [
                'ra_desc'           => $data['eassName'],
                'ra_qty'            => $newQty,
                'ra_rent_period'    => $data['erentPerd'],
                'ra_amount'         => $data['enmemAmt'],
                'ra_amount_member'  => $data['ememAmt'],
                'ra_damage_amount'  => $data['edamAmt'],
                'ra_penalty_amount' => $data['epenAmt'],
                'ra_date_purch'     => $data['edatePurch'],
                'ra_status'         => $data['estatus']
            ];

            $this->db->where('id', $id);
            $this->db->set('ra_vacant_qty', 'ra_vacant_qty + ' . $qtyDifference, FALSE);
            $update = $this->db->update('rental_asset', $assetData);

            if ($update) {
                echo json_encode(['success' => true, 'message' => 'Asset updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }
}
