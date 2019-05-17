<?php

class  Comments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('comment_model');
        $this->load->model('post_model');
        $this->load->model('user_model');
    }

    public function create()
    {
        $post_id = $this->input->post('post_id');
        $post_slug = $this->input->post('post_slug');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('body', 'Body', 'required');

        if($this->form_validation->run() === FALSE)
        {
            redirect('posts/' . $post_id . '/' . $post_slug);
        }
        else
        {
            $data_db = array(
                'post_id' => $post_id,
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'body' => $this->input->post('body')
            );
            $this->comment_model->insert($data_db);

            redirect('posts/' . $post_id . '/' . $post_slug);
        }
    }

    public function delete()
    {
        $comment_id = $this->input->post('comment_id');
        $post_id = $this->input->post('post_id');
        $comment = $this->comment_model->get(array('id' => $comment_id));

        if(empty($comment))
        {
            redirect('pages/error_404');
        }

        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $post = $this->post_model->get(array('id' => $post_id));
        if(empty($post))
        {
            redirect('pages/error_404');
        }

        $post_slug = $post->slug;
        $user_loggedin = $this->user_model->get(array('id' => $this->session->userdata('user_id')));
        if($post->user_id !== $this->session->userdata('user_id') && $user_loggedin->role !== 'admin')
        {
            redirect('posts/' . $post_id . '/' . $post_slug);
        }

        $this->comment_model->delete_by_id($comment_id);

        redirect('posts/' . $post_id . '/' . $post_slug);
    }
}
