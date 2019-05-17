<?php

class Posts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('category_model');
        $this->load->model('comment_model');
        $this->load->model('user_model');
    }

    public function index($page_num = 1)
    {
        if($page_num < 1)
        {
            redirect('pages/error_404');
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'posts/page';
        $config['total_rows'] = $this->post_model->get_count();
        $config['per_page'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['first_url'] = '1';
        $config['attributes'] = array('class' => 'pagination-links');

        $this->pagination->initialize($config);

        $data_head['title'] = 'Latest Posts';
        $data_posts['posts'] = $this->category_model->get_posts_by_category(
            $start = ($config['per_page']*($page_num-1)),
            $where = array(),
            $select = '*',
            $limit = $config['per_page']
        );

        $this->load->view('templates/header', $data_head);
        $this->load->view('posts/index', $data_posts);
        $this->load->view('templates/footer');
    }

    public function view($id)
    {
        $data_post['post'] = $this->post_model->get(array('id' => $id));

        if(empty($data_post['post']))
        {
            redirect('pages/error_404');
        }

        $category_id = $data_post['post']->category_id;
        $data_post['category'] = $this->category_model->get(array('id' => $category_id))->name;
        $data_head['title'] = $data_post['post']->title;
        $data_post['comments'] = $this->comment_model->get_all(
            $start = 0,
            $where = array('post_id' => $id),
            $select = '*',
            $limit = 12
        );

        $this->load->helper('form');

        $this->load->view('templates/header', $data_head);
        $this->load->view('posts/view', $data_post);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $data_head['title'] = 'Create Post';
        $data_categories['categories'] = $this->category_model->get_all();

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');

        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data_head);
            $this->load->view('posts/create', $data_categories);
            $this->load->view('templates/footer');
        }
        else
        {
            // Upload Image configs
            $config['upload_path'] = './assets/images/posts';
            $config['file_name'] = time() . '_' . mt_rand() . '_' . $_FILES['userfile']['name'];
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['max_width'] = 2000;
            $config['max_height'] = 2000;

            // Load upload library
            $this->load->library('upload', $config);

            // Do upload
            if( ! $this->upload->do_upload())
            {
                $errors = array('error' => $this->upload->display_errors());
                $image = 'noimage.jpg';
            }
            else
            {
                $data_upload = array('upload_data' => $this->upload->data());
                $image = $config['file_name'];
            }

            // Create thumb
            if($image !== 'noimage.jpg')
            {
                $config['image_library'] = 'gd2';
                $config['create_thumb'] = TRUE;
                $config['thumb_marker'] = '_thumb';
                $config['width'] = 250;
                $config['height'] = 250;
                $config['maintain_ratio'] = TRUE;
                $config['source_image'] = './assets/images/posts/' . $image;
                $config['new_image'] = './assets/images/posts/thumbnails';

                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
            }

            $slug = url_title(
                convert_accented_characters($this->input->post('title')),
                'dash',
                TRUE
            );
            $data_db = array(
                'category_id' => $this->input->post('category_id'),
                'user_id' => $this->session->userdata('user_id'),
                'slug' => $slug,
                'title' => $this->input->post('title'),
                'body' => $this->input->post('body'),
                'image' => $image,
                'thumbnail' => pathinfo($image, PATHINFO_FILENAME) . '_thumb' . '.' . pathinfo($image, PATHINFO_EXTENSION)
            );
            $this->post_model->insert($data_db);

            // Set message
            $this->session->set_flashdata('post_created', 'Your post has been created.');

            redirect('posts');
        }
    }

    public function edit($id)
    {
        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $data_post['post'] = $this->post_model->get(array('id' => $id));

        if(empty($data_post['post']))
        {
            redirect('pages/error_404');
        }

        $user_loggedin = $this->user_model->get(array('id' => $this->session->userdata('user_id')));
        if($data_post['post']->user_id !== $this->session->userdata('user_id') && $user_loggedin->role !== 'admin')
        {
            redirect('posts/' . $data_post['post']->id . '/' . $data_post['post']->slug);
        }

        // Old image to delete later
        $old_image = $data_post['post']->image;

        // Old thumbnail to delete later
        $old_thumbnail = $data_post['post']->thumbnail;

        $data_post['categories'] = $this->category_model->get_all();

        if(empty($data_post['post']))
        {
            redirect('pages/error_404');
        }

        $data_head['title'] = $data_post['post']->title;

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');

        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data_head);
            $this->load->view('posts/edit', $data_post);
            $this->load->view('templates/footer');
        }
        else
        {
            // Upload Image configs
            $config['upload_path'] = './assets/images/posts';
            $config['file_name'] = time() . '_' . mt_rand() . '_' . $_FILES['userfile']['name'];
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['max_width'] = 2000;
            $config['max_height'] = 2000;

            // Load upload library
            $this->load->library('upload', $config);

            // Do upload
            if( ! $this->upload->do_upload())
            {
                $errors = array('error' => $this->upload->display_errors());
                $image = 'noimage.jpg';
            }
            else
            {
                $data_upload = array('upload_data' => $this->upload->data());
                $image = $config['file_name'];
            }

            // Delete old image if exists (different than noimage.jpg)
            if($old_image !== 'noimage.jpg')
            {
                unlink('./assets/images/posts/' . $old_image);
            }

            // Create thumb
            if($image !== 'noimage.jpg')
            {
                $config['image_library'] = 'gd2';
                $config['create_thumb'] = TRUE;
                $config['thumb_marker'] = '_thumb';
                $config['width'] = 250;
                $config['height'] = 250;
                $config['maintain_ratio'] = TRUE;
                $config['source_image'] = './assets/images/posts/' . $image;
                $config['new_image'] = './assets/images/posts/thumbnails';

                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
            }

            // Delete old thumbnail if exists (different than noimage_thumb.jpg)
            if($old_thumbnail !== 'noimage_thumb.jpg')
            {
                unlink('./assets/images/posts/thumbnails/' . $old_thumbnail);
            }

            $slug = url_title(
                convert_accented_characters($this->input->post('title')),
                'dash',
                TRUE
            );
            $data_db = array(
                'title' => $this->input->post('title'),
                'slug' => $slug,
                'body' => $this->input->post('body'),
                'category_id' => $this->input->post('category_id'),
                'image' => $image,
                'thumbnail' => pathinfo($image, PATHINFO_FILENAME) . '_thumb' . '.' . pathinfo($image, PATHINFO_EXTENSION)
            );
            $this->post_model->update($data_db, array('id' => $id));

            // Set message
            $this->session->set_flashdata('post_updated', 'Your post has been updated.');

            redirect('posts/' . $id . '/' . $slug);
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $post = $this->post_model->get(array('id' => $id));

        if(empty($post))
        {
            redirect('pages/error_404');
        }

        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $user_loggedin = $this->user_model->get(array('id' => $this->session->userdata('user_id')));
        if($post->user_id !== $this->session->userdata('user_id') && $user_loggedin->role !== 'admin')
        {
            redirect('posts/' . $post->id . '/' . $post->slug);
        }

        if($post->image !== 'noimage.jpg')
        {
            unlink('./assets/images/posts/' . $post->image);
        }

        if($post->thumbnail !== 'noimage_thumb.jpg')
        {
            unlink('./assets/images/posts/thumbnails/' . $post->thumbnail);
        }

        $this->post_model->delete_by_id($id);
        $this->comment_model->delete(array('post_id' => $id));

        // Set message
        $this->session->set_flashdata('post_deleted', 'Your post has been deleted.');

        redirect('posts');
    }
}
