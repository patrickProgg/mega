<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Cont extends CI_Controller {

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
		$this->load->view('user');
		$this->load->view('layouts/footer');
	}

	function users() //displays the list of users in the table for Admin users
      {
         $search_value = $_POST['search']['value'];
         $users_list = $this->Mms_mod->select("*","reorder_users","");
         
         foreach ($users_list as &$user) {
            
            $user_details = $this->User_mod->get_pis_employee($user["emp_id"]);
            // $has_key = $this->Acct_mod->checkKeyExist($user["user_id"]);

            if(isset($user_details)){
               $bu = $this->Acct_mod->get_pis_bu_name($user_details["bunit_code"], $user_details["company_code"]);
               $dept = $this->Acct_mod->get_pis_dept_name($user_details["bunit_code"], $user_details["company_code"], $user_details["dept_code"]);
            }

            $user["name"] = isset($user_details) ? $user_details["name"] : "";
            $user["position"] = isset($user_details) ? $user_details["position"] : "";
            $user["dept"] = isset($dept) ? $dept["dept_name"] : "";
            $user["bu"] = isset($bu) ? $bu["business_unit"] : "";
            // $user["has_key"] = $has_key;


         }

         $result_data = array();

         if($search_value === "")
            $result_data = $users_list;
         else{

            foreach($users_list as $user){
               if(stripos($user["name"], $search_value) !== false)
                  $result_data[] = $user;
            }

         }
         

         $table_data = array_slice($result_data,$_POST['start'],$_POST['length']);

         $output = array(  
                  "draw"                      =>     $_POST["draw"],  
                  "recordsTotal"              =>     count($result_data),  
                  "recordsFiltered"           =>     count($result_data),  
                  "data"                      =>     $table_data  
            );  

         echo json_encode($output); 
      }

}
