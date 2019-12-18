<?php
    //获取表的IDS组 表名，字段，条件
    function get_table_ids ( $table, $idname, $where ) {
        $CI = &get_instance ();
        $CI->load->database ();
        $CI->db->where ( $where );
        $CI->db->select ( $idname );
        $query = $CI->db->get ( $table );
        $data = $query->result_array ();
        $pdata = array();
        foreach ( $data as $v ) {
            $pdata[] = $v[ $idname ];
        }

        return $pdata;
    }

    //获取表的IDS组 表名，字段，条件
    function get_table_groupids ( $table, $ids ) {
        $CI = &get_instance ();
        $CI->load->database ();
        $CI->db->where_in ( 'id', $ids );
        $CI->db->select ( 'id,parentid' );
        $query = $CI->db->get ( $table );
        $data = $query->result_array ();
        $pdata = array();
        foreach ( $data as $v ) {
            $pdata[ $v[ 'parentid' ] ][] = $v[ 'id' ];
        }

        return $pdata;
    }

