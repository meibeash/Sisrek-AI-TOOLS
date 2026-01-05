<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recommendation extends CI_Controller {

    public function index()
    {
        // Pastikan user login
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('auth/login');
        }

        $this->load->model(['Tool_model', 'Rating_model']);

        // Content-Based Filtering dengan Cosine Similarity
        $tool_ids = $this->Rating_model->get_recommendations($user_id, 8);

        // Jika ada hasil → pakai itu, jika kosong → fallback popular
        if (!empty($tool_ids)) {
            $data['tools'] = $this->Tool_model->find_many($tool_ids);
        } else {
            $data['tools'] = $this->Tool_model->popular();
        }

        // Load view
        $this->load->view('layout/header');
        $this->load->view('ai_tools/recommendation', $data);
        $this->load->view('layout/footer');
    }
}
