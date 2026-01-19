<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Rating extends CI_Controller {

    public function submit()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('auth/login');
        }

        $this->load->model('Rating_model');

        $this->Rating_model->save([
            'user_id' => $user_id,
            'tool_id' => $this->input->post('tool_id'),
            'rating'  => $this->input->post('rating')
        ]);

        // AUTO-TRAIN SVD Model setiap ada rating baru
        // Coba train Python SVD (jika server jalan)
        $this->Rating_model->train_svd_model();
        
        // Train PHP SVD juga (backup jika Python tidak jalan)
        $this->load->model('Svd_model');
        $this->Svd_model->train();

        // Count user ratings
        $rating_count = $this->db->where('user_id', $user_id)->count_all_results('ratings');
        
        // Success message with rating count
        $this->session->set_flashdata('success', 
            "Rating berhasil ditambahkan! Model SVD diperbarui. Anda sudah memiliki {$rating_count} transaksi rating."
        );

        // Redirect ke recommendations jika sudah punya cukup rating
        if ($rating_count >= 3) {
            redirect('recommendation');
        } else {
            // Belum cukup rating, arahkan untuk rating lebih banyak
            $this->session->set_flashdata('info', 
                "Tambahkan " . (3 - $rating_count) . " rating lagi untuk mendapat rekomendasi yang lebih akurat!"
            );
            redirect('tools');
        }
    }

    public function my()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('auth/login');
        }

        $this->load->model('Rating_model');
        $data['ratings'] = $this->Rating_model->my_ratings($user_id);

        $this->load->view('layout/header');
        $this->load->view('rating/rating', $data);
        $this->load->view('layout/footer');
    }
}

?>