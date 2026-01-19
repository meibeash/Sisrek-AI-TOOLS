<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_tools extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // database & session sudah dari autoload
        $this->load->model('Ai_tool_model');
        $this->load->model('Rating_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['tools'] = $this->Ai_tool_model->get_all_tools();
        $this->load->view('ai_tools/index', $data);
    }

public function rate()
{
    if (!$this->session->userdata('logged_in')) {
        redirect('auth/login');
    }

    $this->Rating_model->save_rating([
        'user_id' => $this->session->userdata('user_id'),
        'tool_id' => $this->input->post('tool_id'),
        'rating'  => $this->input->post('rating')
    ]);

    // ✅ SET NOTIF
    $this->session->set_flashdata(
        'success',
        'Rating berhasil ditambahkan!'
    );

    redirect('ai_tools');
}

}
