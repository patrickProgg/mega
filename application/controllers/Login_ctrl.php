<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_ctrl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_mod');
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('templates/login_css');
        $this->load->view('user/login');
    }

    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Login_mod->authenticate($username, $password);

        if ($user) {
            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('usertpe', $user->user_type);

            echo json_encode(['success' => true, 'redirect' => site_url('dashboard')]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid username/email or password.']);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
