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

        // Redirect ke homepage (akan otomatis tampil rekomendasi)
        redirect('/');
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