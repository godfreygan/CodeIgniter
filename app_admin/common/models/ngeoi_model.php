<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ngeoi_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    /**
     * +------------------------------------------------------
     * 获取总页数
     * +------------------------------------------------------
     */
    public function d_get_total($table = '', $condition = '')
    {
        if(empty($table))
            return false;
        if(!empty($condition))
            $this->db->where($condition);
        $this->db->where('deleted', 0);
        return $this->db->count_all_results($table);
    }

    /**
     * +------------------------------------------------------
     * 获取数据集
     * +------------------------------------------------------
     */
    public function d_get_page($table = '', $condition = '', $oby = 'id desc')
    {
        if(empty($table))
            return false;
        if($this->db->field_exists('deleted', $table)) {
            $this->db->where('deleted', 0);
        }
        $page = $this->input->get('p');
        if($page == '' || $page == 0)
            $page = $page + 1;
        $linum = _GLOBAL_CMS_PAGESIZE_;
        if(!empty($condition))
            $this->db->where($condition);
        if(!empty($oby))
            $this->db->order_by($oby);
        $this->db->limit($linum, ($page - 1) * $linum);
        $e = $this->db->get($table);
        return $e->result_array();
    }

    /**
     * +------------------------------------------------------
     * 获取指定表记录
     * +------------------------------------------------------
     */
    public function d_get($table = '', $condition = '', $return = '', $oby = 'id desc')
    {
        if($this->db->field_exists('deleted', $table)) {
            $this->db->where('deleted', 0);
        }

        if(empty($table)) {
            return false;
        }
        if(!empty($condition)) {
            $this->db->where($condition);
        }
        if(!empty($oby)) {
            $this->db->order_by($oby);
        }

        $e = $this->db->get($table);
        if($return == 'single')
            return $e->row_array();
        else
            return $e->result_array();
    }
}
