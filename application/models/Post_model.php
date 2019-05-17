<?php

class Post_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'posts';
    }

    public function get_comments_to_user_post($user_id)
    {
        return $this->db->order_by('comments.id', 'desc')
            ->join('comments', 'comments.post_id = posts.id')
            ->where('posts.user_id', $user_id)
            ->get($this->table)
            ->result();
    }
}
