<?php

class History_ctrl extends CI_Controller
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
        $this->load->view('user/history');
        $this->load->view('templates/footer');
    }
}
