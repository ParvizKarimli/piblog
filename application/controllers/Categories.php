<?php

class Categories extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('post_model');
        $this->load->model('user_model');
    }

    public function index()
    {
        $data_head['title'] = 'Categories';
        $data_categories['categories'] = $this->category_model->get_all();

        $this->load->helper('form');

        $this->load->view('templates/header', $data_head);
        $this->load->view('categories/index', $data_categories);
        $this->load->view('templates/footer');
    }

    public function view($id, $page_num = 1)
    {
        if($page_num < 1)
        {
            redirect('pages/error_404');
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'categories/' . $id . '/page';
        $config['total_rows'] = $this->post_model->get_count(
            array('category_id' => $id)
        );
        $config['per_page'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['first_url'] = '1';
        $config['uri_segment'] = 4;
        $config['attributes'] = array('class' => 'pagination-links');

        $this->pagination->initialize($config);

        $data_category['category'] = $this->category_model->get(array('id' => $id));

        if(empty($data_category['category']))
        {
            redirect('pages/error_404');
        }
        
        $data_head['title'] = $data_category['category']->name;
        $data_category_posts['category_posts'] = $this->post_model->get_all(
            $start = ($config['per_page']*($page_num-1)),
            $where = array('category_id' => $id),
            $select = '*',
            $limit = $config['per_page']
        );

        $this->load->view('templates/header', $data_head);
        $this->load->view('categories/view', $data_category_posts);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $data_head['title'] = 'Create Category';

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[categories.name]');

        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data_head);
            $this->load->view('categories/create');
            $this->load->view('templates/footer');
        }
        else
        {
            $data_db = array(
                'user_id' => $this->session->userdata('user_id'),
                'name' => $this->input->post('name')
            );

            $this->category_model->insert($data_db);

            // Set message
            $this->session->set_flashdata('category_created', 'Your category has been created.');

            redirect('categories');
        }
    }

    public function edit($id)
    {
        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $data_category['category'] = $this->category_model->get(array('id' => $id));

        if(empty($data_category['category']))
        {
            redirect('pages/error_404');
        }

        $user_loggedin = $this->user_model->get(array('id' => $this->session->userdata('user_id')));
        if($data_category['category']->user_id !== $this->session->userdata('user_id') && $user_loggedin->role !== 'admin')
        {
            redirect('categories');
        }

        $data_head['title'] = $data_category['category']->name;

        $this->load->helper('form');
        $this->load->library('form_validation');

        if($data_category['category']->name === $this->input->post('name'))
        {
            $this->form_validation->set_rules('name', 'Name', 'required');
        }
        else
        {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[categories.name]');
        }

        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data_head);
            $this->load->view('categories/edit', $data_category);
            $this->load->view('templates/footer');
        }
        else
        {
            $data_db = array(
                'name' => $this->input->post('name')
            );

            $this->category_model->update($data_db, array('id' => $id));

            // Set message
            $this->session->set_flashdata('category_updated', 'Your category has been updated.');

            redirect('categories');
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $category = $this->category_model->get(array('id' => $id));

        if(empty($category))
        {
            redirect('pages/error_404');
        }

        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $user_loggedin = $this->user_model->get(array('id' => $this->session->userdata('user_id')));
        if($category->user_id !== $this->session->userdata('user_id') && $user_loggedin->role !== 'admin')
        {
            redirect('categories');
        }

        $this->category_model->delete_by_id($id);

        // Set message
        $this->session->set_flashdata('category_deleted', 'Your category has been deleted.');

        redirect('categories');
    }
}
