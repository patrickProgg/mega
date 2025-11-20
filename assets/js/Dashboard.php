<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();            
		if($this->session->username == "")
		{
			redirect('login-a');
		}

	}

	public function index()
	{
		$this->load->view('layouts/header');
		$this->load->view('dashboard');
		$this->load->view('layouts/footer');
	}
	public function index2()
	{
		$this->load->view('layouts/header');
		$this->load->view('dashboard2');
		$this->load->view('layouts/footer');
	}
}
