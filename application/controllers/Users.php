<?php

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('category_model');
        $this->load->model('post_model');
        $this->load->model('comment_model');
    }

    public function register()
    {
        // Check login
        if($this->session->userdata('logged_in'))
        {
            redirect(base_url());
        }

        $data_head['title'] = 'Sign Up';

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required|min_length[6]|matches[password]');

        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data_head);
            $this->load->view('users/register');
            $this->load->view('templates/footer');
        }
        else
        {
            // Hash password
            $password_hashed = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

            $data_db = array(
                'name' => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'password' => $password_hashed
            );

            $this->user_model->insert($data_db);

            $user_id = $this->user_model->get(array('username' => $this->input->post('username')))->id;

            // Set session data
            $user_data = array(
                'user_id' => $user_id,
                'username' => $this->input->post('username'),
                'logged_in' => TRUE
            );
            $this->session->set_userdata($user_data);

            // Set message
            $this->session->set_flashdata('user_registered', 'You are now registered and logged in.');

            redirect('posts');
        }
    }

    public function login()
    {
        // Check login
        if($this->session->userdata('logged_in'))
        {
            redirect(base_url());
        }

        $data_head['title'] = 'Sign In';

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data_head);
            $this->load->view('users/login');
            $this->load->view('templates/footer');
        }
        else
        {
            // Check if username exists
            $user = $this->user_model->get(array('username' => $this->input->post('username')));
            if(empty($user->username))
            {
                $data_error['error'] = 'Username does not exist.';

                $this->load->view('templates/header', $data_head);
                $this->load->view('users/login', $data_error);
                $this->load->view('templates/footer');
            }
            else
            {
                // Check if password is correct
                $password_hashed = $this->user_model->get(array('username' => $this->input->post('username')))->password;
                if(password_verify($this->input->post('password'), $password_hashed))
                {
                    $user_id = $this->user_model->get(array('username' => $this->input->post('username')))->id;

                    // Create session
                    $user_data = array(
                        'user_id' => $user_id,
                        'username' => $user->username,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($user_data);

                    // Set message
                    $this->session->set_flashdata('user_loggedin', 'You are now logged in.');

                    redirect('posts');
                }
                else
                {
                    // Set message
                    $this->session->set_flashdata('login_failed', 'Incorrect password.');

                    redirect('users/login');
                }
            }
        }
    }

    public function logout()
    {
        $user_id = $this->input->post('user_id');
        $user = $this->user_model->get(array('id' => $user_id));
        if(empty($user))
        {
            redirect('pages/error_404');
        }

        // Unset user data
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_id');

        // Set message
        $this->session->set_flashdata('user_loggedout', 'You are now logged out.');

        redirect('users/login');
    }

    public function profile($username)
    {
        $user = $this->user_model->get(array('username' => $username));
        if(empty($user))
        {
            redirect('pages/error_404');
        }

        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        echo $user->username;
    }

    public function admin($page)
    {
        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $data['username'] = $this->session->userdata('username');
        /*if(empty($username))
        {
            redirect('users/login');
        }*/

        $data['user'] = $this->user_model->get(array('username' => $data['username']));
        if(empty($data['user']))
        {
            redirect('users/login');
        }

        $this->load->view('users/admin/templates/header', $data);
        $this->load->view('users/admin/templates/top', $data);
        $this->load->view('users/admin/templates/side', $data);
        if( ! file_exists(APPPATH . 'views/users/admin/' . $page . '.php'))
        {
            redirect('pages/error_404');
        }
        else
        {
            $user_id = $data['user']->id;
            if($page === 'categories')
            {
                if($data['user']->role === 'admin')
                {
                    $data['categories'] = $this->category_model->get_all();
                }
                else
                {
                    $data['categories'] = $this->category_model->get_all(
                        $start = 0, $where = array('user_id' => $user_id), $select = '*', $limit = 12
                    );
                }
            }
            elseif($page === 'posts')
            {
                if($data['user']->role === 'admin')
                {
                    $data['posts'] = $this->category_model->get_posts_by_category();
                }
                else
                {
                    $data['posts'] = $this->category_model->get_posts_by_category(
                        $start = 0,
                        $where = array('posts.user_id' => $user_id),
                        $select = '*',
                        $limit = 12
                    );
                }
            }
            elseif($page === 'comments')
            {
                if($data['user']->role === 'admin')
                {
                    $data['comments'] = $this->comment_model->get_all();
                }
                else
                {
                    $data['comments'] = $this->post_model->get_comments_to_user_post($user_id);
                }
            }
            elseif($page === 'users')
            {
                if($data['user']->role === 'admin'){
                    $data['users'] = $this->user_model->get_all();
                }
                else
                {
                    redirect('admin/user');
                }
            }
            $this->load->view('users/admin/' . $page, $data);
        }
        $this->load->view('users/admin/templates/footer');
    }

    public function edit($id)
    {
        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $user_loggedin = $this->user_model->get(array('id' => $this->session->userdata('user_id')));
        if($id !== $this->session->userdata('user_id') && $user_loggedin->role !== 'admin')
        {
            redirect('admin/user');
        }

        $data_head['title'] = 'Edit User';
        $data_user['user'] = $this->user_model->get(array('id' => $id));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        if($data_user['user']->username === $this->input->post('username'))
        {
            $this->form_validation->set_rules('username', 'Username', 'required');
        }
        else
        {
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        }
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required|min_length[6]|matches[password]');

        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data_head);
            $this->load->view('users/edit', $data_user);
            $this->load->view('templates/footer');
        }
        else
        {
            // Hash password
            $password_hashed = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

            $data_db = array(
                'name' => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'password' => $password_hashed
            );

            $this->user_model->update($data_db, array('id' => $id));

            // Set session data
            $user_data = array(
                'user_id' => $id,
                'username' => $this->input->post('username'),
                'logged_in' => TRUE
            );
            $this->session->set_userdata($user_data);

            // Set message
            $this->session->set_flashdata('user_updated', 'User updated successfully.');

            redirect('admin/user');
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $user = $this->user_model->get(array('id' => $id));

        if(empty($user))
        {
            redirect('pages/error_404');
        }

        // Check login
        if( ! $this->session->userdata('logged_in'))
        {
            redirect('users/login');
        }

        $user_loggedin = $this->user_model->get(array('id' => $this->session->userdata('user_id')));

        if(
            $this->session->userdata('user_id') !== $user->id &&
            $user_loggedin->role !== 'admin'
        )
        {
            redirect('admin/user');
        }

        $this->user_model->delete_by_id($id);

        if($user_loggedin->role === 'admin')
        {
            redirect('admin/users');
        }
        else
        {
            redirect('admin/user');
        }
    }
}
