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

        // SVD Model-Based Collaborative Filtering
        $svd_result = $this->Rating_model->get_svd_recommendations($user_id, 8);

        // Ambil tools berdasarkan hasil rekomendasi
        if (!empty($svd_result['tool_ids'])) {
            $data['tools'] = $this->Tool_model->find_many($svd_result['tool_ids']);
            $data['predictions'] = $svd_result['predictions'];
        } else {
            // Fallback ke popular jika tidak ada rekomendasi
            $data['tools'] = $this->Tool_model->popular();
            $data['predictions'] = [];
        }

        $data['algorithm'] = $svd_result['algorithm'];
        $data['svd_success'] = $svd_result['success'];

        // Load view
        $this->load->view('layout/header');
        $this->load->view('ai_tools/recommendation', $data);
        $this->load->view('layout/footer');
    }

    /**
     * AJAX endpoint untuk train model
     */
    public function train_model()
    {
        $this->load->model('Rating_model');
        $result = $this->Rating_model->train_svd_model();
        
        header('Content-Type: application/json');
        echo json_encode($result ?: ['error' => 'Failed to train model']);
    }

    /**
     * AJAX endpoint untuk model info
     */
    public function model_info()
    {
        $this->load->model('Rating_model');
        $result = $this->Rating_model->get_svd_model_info();
        
        header('Content-Type: application/json');
        echo json_encode($result ?: ['error' => 'Failed to get model info']);
    }
}
