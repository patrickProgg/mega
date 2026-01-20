<?php

class Loan_ctrl extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
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
        $this->load->view('user/loan');
        $this->load->view('templates/footer');
    }

    public function get_loaner()
    {
        $start = $this->input->post('start');
		$length = $this->input->post('length');
		$searchValue = $this->input->post('search')['value'];

        $this->db->select('
            a.id,
            a.loan_amt,
            a.status,
            a.loan_date,
            a.return_date,
            CONCAT(b.fname, " ", b.lname) AS full_name,
            b.province,
            b.phone1
        ');

        $this->db->from('tbl_loan as a');
        $this->db->join('user_hd as b', 'b.hd_id = a.member_id', 'left');
        $this->db->group_by('a.id');

        if (!empty($searchValue)) {
			$this->db->group_start();
			$this->db->like('b.fname', $searchValue);
			$this->db->or_like('b.province', $searchValue);
			$this->db->or_like('a.status', $searchValue);
			$this->db->or_like('a.loan_date', $searchValue);
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

    public function save_loaner(){
        $id = $this->input->post('id');
        $date = $this->input->post('date');
        $amount = $this->input->post('amount');

        $data = array(
            'member_id' => $id,
            'loan_amt' => str_replace(',', '', $amount),
            'loan_date' => $date,
            'user_id' => $this->session->userdata('user_id')
        );

        $inserted = $this->db->insert('tbl_loan', $data);

        $amount_clean = str_replace(',', '', $amount);
        $amount_clean = (float) $amount_clean;

        $this->db->set('bal', 'bal - ' . $amount_clean, FALSE);
        $this->db->update('fund');

        if ($inserted) {
            echo json_encode(array('status' => 'success', 'message' => 'Loan record saved successfully.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save loan record.'));
        }
    }

    public function get_loan_details(){
        $id = $this->input->post('id');

         $this->db->select('
            id,
            month,
            interest_rate,
            interest_amt,
            payment_date
        ');
        $this->db->from('tbl_interest_payment');
        $this->db->where('loan_id', $id);

        $query = $this->db->get();
		$data = $query->result_array();

        echo json_encode($data);
    }

    public function pay_loan(){
        $id = $this->input->post('id');
        $month = $this->input->post('month');
        $interest_rate = $this->input->post('interest_rate');
        $interest_amount = $this->input->post('interest_amount');
        $payment_date = $this->input->post('payment_date');

        if ($interest_rate == 0.1) {
            $rate_enum = "10%";
        } else {
            $rate_enum = "5%";
        }

        $data = array(
            'loan_id' => $id,
            'month' => $month,
            'interest_rate' => $rate_enum,
            'interest_amt' => $interest_amount,
            'payment_date' => $payment_date,
            'user_id' => $this->session->userdata('user_id')
        );

        $inserted = $this->db->insert('tbl_interest_payment', $data);

        $amount_clean = str_replace(',', '', $interest_amount);
        $amount_clean = (float) $amount_clean;

        $this->db->set('loan_bal', 'loan_bal + ' . $amount_clean, FALSE);
        $this->db->set('bal', 'bal + ' . $amount_clean, FALSE);
        $this->db->update('fund');

        if ($inserted) {
            echo json_encode(array('status' => 'success', 'message' => 'Loan payment for ' . $month . ' saved successfully.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save loan payment.'));
        }
    }

    public function return_principal(){
        $id = $this->input->post('id');
        $amount = $this->input->post('amount');

        $data = array(
            'status' => 'completed',
            'return_date' => date('Y-m-d')
        );

        $this->db->where('id', $id);
        $updated = $this->db->update('tbl_loan', $data);

        $amount_clean = str_replace(',', '', $amount);
        $amount_clean = (float) $amount_clean;

        $this->db->set('bal', 'bal + ' . $amount_clean, FALSE);
        $this->db->update('fund');

        if ($updated) {
            echo json_encode(array('status' => 'success', 'message' => 'Principal amount returned successfully.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to return principal amount.'));
        }
    }
}