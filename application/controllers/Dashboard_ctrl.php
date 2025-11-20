<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_ctrl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_mod');
        $this->load->model('User_mod');
        $this->load->model('Login_mod');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $total_members = $this->Dashboard_mod->get_totals();
        $data['total_members'] = $total_members['total_members'];
        $data['details'] = $total_members['data'];

        $late_members = $this->Dashboard_mod->total_late_members();
        $data['total_late_members'] = $late_members['total_late_members'];
        $data['late_details'] = $late_members['data'];

        $total_fund = $this->Dashboard_mod->total_fund();
        $data['total_fund'] = $total_fund['total_fund'];
        $data['total_rent_revenue'] = $total_fund['total_rent_revenue'];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/navbar');
        $this->load->view('user/dashboard', $data);
        $this->load->view('templates/footer');
    }
}
