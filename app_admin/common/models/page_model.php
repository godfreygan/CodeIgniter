<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    /**
     * +------------------------------------------------------
     * 分页调用
     * +------------------------------------------------------
     */
    public function get($url, $total, $num = 30) {
        //装载类文件
        $this->load->library('pagination');
        //每页显示10条数据
        $page_size = $num;

        $config['base_url'] = $url;
        //一共有多少条数据
        $config['total_rows'] = $total;
        //每页显示条数
        $config['per_page'] = $page_size;
        $config['first_link'] = '首页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '末页';

        $config['first_tag_open'] = '<li class="page-first">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-last">';
        $config['last_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-next">';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['use_page_numbers'] = TRUE;

        $config['query_string_segment'] = 'p';
        //$config['uri_segment'] = 5; //分页的数据查询偏移量在哪一个段上
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
}
