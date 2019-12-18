<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    /**
     * +------------------------------------------------------
     * Reset sort
     * +------------------------------------------------------
     */
    public function resort($table) {
        $ids = $this->input->post('id');
        $sorts = $this->input->post('sort');
        foreach ((array)$sorts as $k => $val) {
            $data[$k]['id'] = $ids[$k];
            $data[$k]['sort'] = $val;
        }
        $this->db->update_batch($table, $data, 'id');
        exit('操作成功');
    }

    /**
     * +------------------------------------------------------
     * 是否有某数据
     * +------------------------------------------------------
     */
    public function d_is_exist($table = '', $condition = '', $return = '') {
        if (empty($table)) {
            return false;
        }
        if (!empty($condition)) {
            $this->db->where($condition);
        }
        $this->db->where('deleted', 0);
        $e = $this->db->get($table);
        if ($return == 'array') {
            return $e->result_array();
        } elseif ($return == 'row') {
            return $e->row_array();
        } else {
            return $this->db->affected_rows();
        }
    }

    /**
     * +------------------------------------------------------
     * 删除数据(逻辑)
     * +------------------------------------------------------
     */
    public function d_delete($table = '', $id = array(), $primary = 'id') {
        if (empty($table) || empty($primary) || empty($id)) {
            return false;
        }
        $this->db->where_in($primary, $id)->set('deleted', 1)
            ->update($table);

        return $this->db->affected_rows();
    }
}
