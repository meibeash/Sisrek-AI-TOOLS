<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function create($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_by_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->get('users')
            ->row();
    }
}
