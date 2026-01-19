<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_tool_model extends CI_Model {

    public function get_all_tools()
    {
        return $this->db->get('ai_tools')->result();
    }
}
