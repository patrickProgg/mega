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


    public function getData()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');
            $status = $this->input->post('status');
            $address = $this->input->post('address');

            // var_dump($status);

            $column_index = isset($order[0]['column']) ? $order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';

            $data = $this->User_mod->getData($start, $length, $column_index, $sort_direction, $search, $status, $address);

            $response = [

                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
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

    // public function sendTo()
    // {
    //     if ($this->input->is_ajax_request()) {
    //         $user_id = $this->input->post('user_id');

    //         $user = $this->db->get_where('user_hd', ['hd_id' => $user_id])->row();
    //         $users = $this->User_mod->getAllActiveUsers();
    //         $totalUsers = $users['total_records'];

    //         $total_amount = $totalUsers * 100;
    //         // var_dump($total_amount);
    //         // exit;

    //         if ($user) {
    //             $data = [
    //                 'hd_id' => $user->hd_id,
    //                 'dd_fname' => $user->fname,
    //                 'dd_mname' => $user->mname,
    //                 'dd_lname' => $user->lname,
    //                 'dd_phone1' => $user->phone1,
    //                 'dd_phone2' => $user->phone2,
    //                 'dd_email' => $user->email,
    //                 'dd_date_joined' => $user->date_joined,
    //                 'dd_total_amt' =>  $total_amount,
    //                 'dd_status' => 2
    //             ];


    //             $this->db->insert('deceased', $data);

    //             $this->db->where('hd_id', $user_id);
    //             $this->db->update('user_hd', ['status' => 2]);
    //             // Optional: Delete from the original table
    //             // $this->db->delete('users', ['id' => $user_id]);

    //             echo json_encode(['status' => 'success']);
    //         } else {
    //             echo json_encode(['status' => 'error']);
    //         }
    //     }
    // }

    public function sendTo()
    {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->input->post('user_id');
            $date_died = $this->input->post('date_died');

            // Fetch user details
            $user = $this->db->get_where('user_hd', ['hd_id' => $user_id])->row();

            if (!$user) {
                echo json_encode(['status' => 'error']);
                return;
            }

            // Fetch all active users excluding the deceased user
            $this->db->select('hd_id');
            $this->db->from('user_hd');
            $this->db->where('hd_id !=', $user_id); // Exclude deceased user
            $allUsers = $this->db->get()->result();

            $totalUsers = count($allUsers); // Count of users in death_fund
            $total_amount = $totalUsers * 100;
            // $date_today = date('Y-m-d');
            $deadline = date('Y-m-d', strtotime($date_died . ' +3 days'));
            // Insert into deceased table
            $data = [
                'hd_id' => $user->hd_id,
                'dd_date_died' => $date_died,
                'dd_total_amt' => $total_amount,
                'dd_dead_line' => $deadline
            ];

            $this->db->insert('deceased', $data);
            $dd_id = $this->db->insert_id(); // Get last inserted dd_id

            // Update user_hd status
            $this->db->where('hd_id', $user_id);
            $this->db->update('user_hd', ['status' => 2]);

            // Prepare data for insertion



            $insertData = [];
            foreach ($allUsers as $u) {
                // Check if entry already exists
                $exists = $this->db->get_where('death_fund', [
                    'dd_id' => $dd_id,
                    'hd_id' => $u->hd_id
                ])->row();

                if (!$exists) { // Only insert if not already in death_fund
                    $insertData[] = [
                        'dd_id' => $dd_id,
                        'hd_id' => $u->hd_id,
                        'amt' => 0,
                        'status' => 0
                    ];
                }
            }

            // Batch insert only if there are new records
            if (!empty($insertData)) {
                $this->db->insert_batch('death_fund', $insertData);
            }

            echo json_encode(['status' => 'success']);
        }
    }



    public function details()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id');

            $data = $this->User_mod->getUserMember($id);
            $hd_id = $this->User_mod->getUserMemberId($id);
            // $data = $this->User_mod->getUserMemberDetails($id);


            $response = array(
                "draw" => intval($this->input->post('draw')), // Required by DataTables
                "recordsTotal" => count($data),
                "recordsFiltered" => count($data),
                "data" => $data,
                "hd_data" => $hd_id
            );

            echo json_encode($response);
            // var_dump($response);
            // exit;
        } else {
            show_error('No direct access allowed');
        }
    }

    public function memberDetails()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id');

            $data = $this->User_mod->getMember($id);

            $response = array(
                "draw" => intval($this->input->post('draw')), // Required by DataTables
                "data" => $data
            );

            echo json_encode($response);
        } else {
            show_error('No direct access allowed');
        }
    }

    public function memberFamDetails()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id');

            $data = $this->User_mod->getFamMember($id);

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

    public function addMember()
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
                'email'    => $data['email'],
                'status'    => 1,
                'date_joined'    => $data['date'],
                // 'city'       => $data['city'],
                // 'state'      => $data['state'],
                // 'zip_code'   => $data['zip_code']
            ];

            // Insert into database
            $insert = $this->db->insert('user_hd', $memberData);

            if ($insert) {
                echo json_encode(['success' => true, 'message' => 'Member added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database insert failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }

    public function updateMember()
    {
        if ($this->input->is_ajax_request()) {

            $data = $this->input->post();
            $id = $data['id'];

            $memberData = [
                'fname'     => $data['fname'],
                'mname'     => $data['mname'],
                'lname'     => $data['lname'],
                'birthday'  => $data['birthday'],
                'age'       => $data['age'],
                'phone1'    => $data['phone1'],
                'phone2'    => $data['phone2'],
                'purok'     => $data['purok'],
                'barangay'  => $data['barangay'],
                'city'      => $data['city'],
                'province'  => $data['province'],
                'zip_code'  => $data['zip_code'],
                'email'     => $data['email'],
                'username'     => $data['username']
            ];

            // Correct update query with WHERE condition
            $this->db->where('hd_id', $id);
            $update = $this->db->update('user_hd', $memberData);

            if ($update) {
                echo json_encode(['success' => true, 'message' => 'Member updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }

    public function updateFamMember()
    {
        if ($this->input->is_ajax_request()) {

            $data = $this->input->post();
            $id = $data['id'];

            $memberData = [
                'fname'     => $data['fname'],
                'mname'     => $data['mname'],
                'lname'     => $data['lname'],
                'birthday'  => $data['birthday'],
                'age'       => $data['age'],
                'phone1'    => $data['phone1'],
                'phone2'    => $data['phone2'],
                'purok'     => $data['purok'],
                'barangay'  => $data['barangay'],
                'city'      => $data['city'],
                'province'  => $data['province'],
                'zip_code'  => $data['zip_code'],
                'email'     => $data['email']
            ];

            // Correct update query with WHERE condition
            $this->db->where('ln_id', $id);
            $update = $this->db->update('user_ln', $memberData);

            if ($update) {
                echo json_encode(['success' => true, 'message' => 'Member updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }

    public function addFamMember()
    {
        if ($this->input->is_ajax_request()) {

            $data = $this->input->post();

            $memberData = [
                'hd_id' => $data['id'],
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'lname'  => $data['lname'],
                'phone1'     => $data['phone1'],
                'phone2'     => $data['phone2'],
                'purok'      => $data['purok'],
                'barangay'      => $data['barangay'],
                'city'      => $data['city'],
                'province'      => $data['province'],
                'zip_code'      => $data['zip_code'],
                'email'    => $data['email'],
                'status'    => 1,
                // 'city'       => $data['city'],
                // 'state'      => $data['state'],
                // 'zip_code'   => $data['zip_code']
            ];

            // Insert into database
            $insert = $this->db->insert('user_ln', $memberData);

            if ($insert) {
                echo json_encode(['success' => true, 'message' => 'Member added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database insert failed']);
            }
        } else {
            show_error('No direct access allowed');
        }
    }
}
