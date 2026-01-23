<?php

class User_ctrl extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->library('session');
        $this->load->model('User_mod');
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
        $this->load->view('user/index');
        $this->load->view('templates/footer');
    }


    public function getHeadData()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchValue = trim($this->input->post('search')['value']);

        $this->db->select("
            hd_id,
            fname,
            mname,
            lname,
            birthday,
            age,
            purok,
            barangay,
            city,
            province,
            zip_code,
            phone1,
            phone2,
            status,
            date_joined,
            CONCAT(fname, ' ', lname) AS full_name, 
            CONCAT_WS(', ', purok, barangay, city, province) AS address
        ");

        $this->db->from('tbl_user_hd');

        $this->db->order_by('hd_id', 'DESC');

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

    public function getHeadDetails()
    {
        $id = $this->input->post('id');

        $this->db->select("
            ln_id,
            fname,
            mname,
            lname,
            birthday,
            age,
            purok,
            barangay,
            city,
            province,
            zip_code,
            phone1,
            phone2,
            status,
            CONCAT(fname, ' ', lname) AS full_name, 
            CONCAT_WS(', ', purok, barangay, city, province) AS address
        ");

        $this->db->from('tbl_user_ln');
        $this->db->where('hd_id', $id);

        $this->db->order_by('ln_id', 'DESC');

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

        $query = $this->db->get();
        $data = $query->result_array();

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $recordsFiltered,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }

    public function upload_csv()
    {
        if (isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['size'] > 0) {
            $file = $_FILES['csv_file']['tmp_name'];
            $handle = fopen($file, "r");

            fgetcsv($handle); // Skip the header row
            $data = [];
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) < 12) {
                    continue; // Skip row if it has fewer columns
                }

                $date = DateTime::createFromFormat('m/d/Y', $row[11]);
                $formatted_date = $date ? $date->format('Y-m-d') : null;

                $data[] = [
                    'fname' => $row[0],
                    'mname' => $row[1],
                    'lname' => $row[2],
                    'purok' => $row[3],
                    'barangay' => $row[4],
                    'city' => $row[5],
                    'province' => $row[6],
                    'zip_code' => $row[7],
                    'phone1' => $row[8] ?? null, // Ensure index exists
                    'phone2' => $row[9] ?? null,
                    'email' => $row[10] ?? null,
                    'date_joined' => $formatted_date,
                    'status' => 1
                ];
            }
            fclose($handle);


            if (!empty($data)) {
                $result = $this->User_mod->insert_csv_data($data);

                if ($result) {
                    $this->session->set_flashdata('success', 'CSV file imported successfully!');
                } else {
                    $this->session->set_flashdata('error', 'Failed to insert CSV data.');
                }
            } else {
                $this->session->set_flashdata('error', 'CSV file is empty or invalid.');
            }
        } else {
            $this->session->set_flashdata('error', 'Please upload a valid CSV file.');
        }

        redirect('User_ctrl/index');
    }

    public function getUser($id)
    {
        $user = $this->db->get_where('users', ['id' => $id])->row();
        echo json_encode($user);
    }

    public function sendTo()
    {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->input->post('user_id');
            $date_died = $this->input->post('date_died');

            $user = $this->db->get_where('tbl_user_hd', ['hd_id' => $user_id])->row();

            if (!$user) {
                echo json_encode(['status' => 'error']);
                return;
            }

            $this->db->select('mort_amt');
            $this->db->from('tbl_charge_info');
            $mortAmtObj = $this->db->get()->row();

            $mortAmt = $mortAmtObj->mort_amt;

            $this->db->select('hd_id');
            $this->db->from('tbl_user_hd');
            $this->db->where('hd_id !=', $user_id); 
            $allUsers = $this->db->get()->result();

            $totalUsers = count($allUsers);
            $total_amount = $totalUsers * $mortAmt;

            $deadline = date('Y-m-d', strtotime($date_died . ' +3 days'));

            $data = [
                'hd_id' => $user->hd_id,
                'date_died' => $date_died,
                'total_amt' => $total_amount,
                'dead_line' => $deadline
            ];

            $this->db->insert('tbl_deceased', $data);
            $dd_id = $this->db->insert_id(); 

            $this->db->where('hd_id', $user_id);
            $this->db->update('tbl_user_hd', ['status' => 'deceased']);

            $insertData = [];
            foreach ($allUsers as $u) {
                $exists = $this->db->get_where('tbl_death_fund', [
                    'dd_id' => $dd_id,
                    'hd_id' => $u->hd_id
                ])->row();

                if (!$exists) { 
                    $insertData[] = [
                        'dd_id' => $dd_id,
                        'hd_id' => $u->hd_id,
                        'amt' => 0,
                        'status' => 0
                    ];
                }
            }

            if (!empty($insertData)) {
                $this->db->insert_batch('tbl_death_fund', $insertData);
            }

            echo json_encode(['status' => 'success']);
        }
    }

    public function addParent()
    {
        if ($this->input->is_ajax_request()) {

            $data = $this->input->post();

            $memberData = [
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'lname'  => $data['lname'],
                'birthday'   => $data['birthday'],
                'age'        => $data['age'],
                'phone1'     => $data['phone1'],
                'phone2'     => $data['phone2'],
                'purok'      => $data['purok'],
                'barangay'      => $data['barangay'],
                'city'      => $data['city'],
                'province'      => $data['province'],
                'zip_code'      => $data['zip_code'],
                'date_joined'    => $data['date_joined'],
            ];

            $insert = $this->db->insert('tbl_user_hd', $memberData);

            if ($insert) {
                echo json_encode(['success' => true, 'message' => 'Member added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database insert failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }

    public function updateParent($id)
    {
        if ($this->input->is_ajax_request()) {
            
            $data = array(
                'fname'     => $this->input->post('fname'),
                'mname'     => $this->input->post('mname'),
                'lname'     => $this->input->post('lname'),
                'birthday'  => $this->input->post('birthday'),
                'age'       => $this->input->post('age'),
                'phone1'    => $this->input->post('phone1'),
                'phone2'    => $this->input->post('phone2'),
                'purok'     => $this->input->post('purok'),
                'barangay'  => $this->input->post('barangay'),
                'city'      => $this->input->post('city'),
                'province'  => $this->input->post('province'),
                'zip_code'  => $this->input->post('zip_code'),
                'date_joined'  => $this->input->post('date_joined')
            );

            $this->db->where('hd_id', $id);
            $update = $this->db->update('tbl_user_hd', $data);

            if ($update) {
                echo json_encode(['success' => true, 'message' => 'Member updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }

    public function addMember($id)
    {
        if ($this->input->is_ajax_request()) {

            $data = $this->input->post();

            $memberData = [
                'hd_id' => $id,
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'lname'  => $data['lname'],
                'birthday'   => $data['birthday'],
                'age'        => $data['age'],
                'phone1'     => $data['phone1'],
                'phone2'     => $data['phone2'],
                'purok'      => $data['purok'],
                'barangay'      => $data['barangay'],
                'city'      => $data['city'],
                'province'      => $data['province'],
                'zip_code'      => $data['zip_code'],
                'status'    => 1,
                'date_joined'    => $data['date_joined'],
            ];

            $insert = $this->db->insert('tbl_user_ln', $memberData);

            if ($insert) {
                echo json_encode(['success' => true, 'message' => 'Member added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database insert failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }

    public function updateMember($id)
    {
        if ($this->input->is_ajax_request()) {
            
            $data = array(
                'fname'     => $this->input->post('fname'),
                'mname'     => $this->input->post('mname'),
                'lname'     => $this->input->post('lname'),
                'birthday'  => $this->input->post('birthday'),
                'age'       => $this->input->post('age'),
                'phone1'    => $this->input->post('phone1'),
                'phone2'    => $this->input->post('phone2'),
                'purok'     => $this->input->post('purok'),
                'barangay'  => $this->input->post('barangay'),
                'city'      => $this->input->post('city'),
                'province'  => $this->input->post('province'),
                'zip_code'  => $this->input->post('zip_code'),
                'date_joined'  => $this->input->post('date_joined')
            );

            $this->db->where('ln_id', $id);
            $update = $this->db->update('tbl_user_ln', $data);

            if ($update) {
                echo json_encode(['success' => true, 'message' => 'Member updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }

}
