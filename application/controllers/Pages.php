<?php

class Pages extends CI_Controller
{
    public function view($page = 'home')
    {
        if( ! file_exists(APPPATH . 'views/pages/' . $page . '.php'))
        {
            redirect('pages/error_404');
        }

        $data_head['title'] = ucfirst($page);

        $this->load->view('templates/header', $data_head);
        $this->load->view('pages/' . $page);
        $this->load->view('templates/footer');
    }

    public function error_404()
    {
        $data_head['title'] = '404 Page Not Found';

        $this->load->view('templates/header', $data_head);
        $this->load->view('pages/error_404');
        $this->load->view('templates/footer');
    }
}
