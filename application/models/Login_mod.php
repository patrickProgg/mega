<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_mod extends CI_Model
{

    public function authenticate($username_or_email, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $this->db->where('username', $username_or_email);
        $this->db->or_where('email', $username_or_email);
        $this->db->where('password', $hashed_password);
        $query = $this->db->get('admin');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }
}
