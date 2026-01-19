<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
    {
        $this->load->model(['Tool_model', 'Rating_model']);
        $user_id = $this->session->userdata('user_id');

        $data['is_logged_in'] = (bool) $user_id;
        $data['has_ratings'] = false;
        $data['is_recommendation'] = false;
        $data['algorithm'] = '';
        $data['predictions'] = [];

        // Jika user login dan sudah punya rating → tampilkan rekomendasi SVD
        if ($user_id && $this->Rating_model->has_rating($user_id)) {
            $data['has_ratings'] = true;
            $data['is_recommendation'] = true;
            
            // SVD Model-Based Collaborative Filtering
            $svd_result = $this->Rating_model->get_svd_recommendations($user_id, 8);

            // Ambil tools berdasarkan rekomendasi
            if (!empty($svd_result['tool_ids'])) {
                $data['tools'] = $this->Tool_model->find_many($svd_result['tool_ids']);
                $data['predictions'] = $svd_result['predictions'];
                $data['algorithm'] = $svd_result['algorithm'];
            } else {
                // Fallback jika tidak ada rekomendasi
                $data['tools'] = $this->Tool_model->popular();
                $data['algorithm'] = 'Popular (Fallback)';
            }
        } else {
            // User belum login atau belum rating → tampilkan trending/popular
            $data['tools'] = $this->Tool_model->popular();
            $data['algorithm'] = 'Popular';
        }

        $this->load->view('layout/header');
        $this->load->view('ai_tools/index', $data);
        $this->load->view('layout/footer');
    }
}
