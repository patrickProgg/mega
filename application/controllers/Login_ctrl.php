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
        $username_or_email = $this->input->post('username_or_email');
        $password = $this->input->post('password');

        $user = $this->Login_mod->authenticate($username_or_email, $password);

        if ($user) {

            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);

            // Set flashdata for greeting message
            $this->session->set_flashdata('login_success', $user->username . '!');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid username/email or password.');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
