<?php

/**
 * @title: 分页调用
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $url      string  分页路径
 * @param $total    integer 总数量
 * @param $num      int     分页量
 * @return mixed
 */
function get_page($url,$total,$num = 10)
{
	$_CI = &get_instance();
	
	//装载类文件
	$_CI->load->library('pagination');
	//每页显示10条数据
	$page_size = $num;
	
	$uarr = $_CI->input->get();
	$str='?';
	foreach($uarr as $k=>$v)
	{
		$str .= '&'.$k.'='.$v;
	}
	$config['base_url'] = $str;
	//一共有多少条数据
	$config['total_rows'] = $total;
	//每页显示条数
	$config['per_page'] = $page_size;
	$config['first_link'] = '';
	$config['prev_link'] = '<';
	$config['next_link'] = '>';
	$config['last_link'] = '';
	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active"><a href="#">';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['use_page_numbers'] = TRUE;
	
	$config['query_string_segment'] = 'p';
	//$config['uri_segment'] = 3; //分页的数据查询偏移量在哪一个段上		
	$_CI->pagination->initialize($config);	
	return $_CI->pagination->create_links();
}
