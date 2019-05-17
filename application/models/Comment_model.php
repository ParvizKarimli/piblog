<?php

class Comment_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'comments';
    }
}
