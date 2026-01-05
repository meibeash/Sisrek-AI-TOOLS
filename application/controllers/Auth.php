<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function register()
    {
        if ($this->input->post()) {
            $this->load->model('User_model');

            $this->User_model->create([
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                )
            ]);

            $this->session->set_flashdata('success', 'Registration successful! Please login.');
            redirect('auth/login');
        }
        $this->load->view('layout/header');
        $this->load->view('auth/register');
        $this->load->view('layout/footer');
    }

    public function login()
    {
        if ($this->input->post()) {
            $this->load->model('User_model');
            $user = $this->User_model->get_by_email(
                $this->input->post('email')
            );

            if ($user && password_verify(
                $this->input->post('password'),
                $user->password
            )) {
                $this->session->set_userdata('user_id', $user->user_id);
                redirect('/');
            }
            
            $this->session->set_flashdata('error', 'Invalid email or password');
        }
        $this->load->view('layout/header');
        $this->load->view('auth/login');
        $this->load->view('layout/footer');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
