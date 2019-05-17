<?php

class Category_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'categories';
    }

    public function get_posts_by_category($start = 0, $where = array(), $select = '*', $limit = 12)
    {
        return $this->db->select($select)->where($where)->limit($limit, $start)->order_by('posts.id', 'desc')
            ->join('posts', 'categories.id = posts.category_id')->get($this->table)->result();
    }
}
