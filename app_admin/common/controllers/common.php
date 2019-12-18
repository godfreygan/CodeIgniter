<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Controller {
    /**
     * +------------------------------------------------------
     * 构造方法
     * +------------------------------------------------------
     */
    public function __construct() {
        parent::__construct();
        $this->load->set_model_path('common')->model(array('page_model', 'common_model'));
    }
}