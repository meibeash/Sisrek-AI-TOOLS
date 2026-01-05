<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tools extends CI_Controller {

    public function index()
    {
        $this->load->model('Tool_model');
        
        $search = $this->input->get('q');
        $category = $this->input->get('category');
        
        $data['tools'] = $this->Tool_model->search($search, $category);
        $data['categories'] = $this->Tool_model->get_categories();
        $data['search'] = $search;
        $data['selected_category'] = $category;
        
        $this->load->view('layout/header');
        $this->load->view('ai_tools/explore', $data);
        $this->load->view('layout/footer');
    }

    public function detail($id)
    {
        $this->load->model('Tool_model');
        $data['tool'] = $this->Tool_model->find($id);
        $this->load->view('layout/header');
        $this->load->view('ai_tools/detail',$data);
        $this->load->view('layout/footer');
    }
}
