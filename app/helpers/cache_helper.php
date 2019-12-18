<?php

/**
 * @title: 生成缓存的名称
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $param    array   传递指定的可以存的参数
 * @return string   string  缓存文件名称
 */
if(!function_exists('generate_cache_filename')) {
    function generate_cache_filename($param)
    {   //$param =array('传递指定的可以存的参数;')
        $request = $_REQUEST;
        $filtered_request = array();
        foreach ($request as $key => $val) {
            if(in_array($key, $param)) {
                $filtered_request[$key] = $val;
            }
        }
        if(isset($_SERVER["REQUEST_URI"])) {
            $source = $_SERVER['HTTP_HOST'] . rtrim(str_replace($_SERVER['QUERY_STRING'], '', $_SERVER["REQUEST_URI"]), '?') . '?' . http_build_query($filtered_request);
        } else {
            return '';
        }
        $cachename = md5($source);
        return $cachename;
    }
}

/**
 * @title: 去获取缓存的信息(通过缓存的名称去获取换成 )
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $cachename        string  缓存文件名称
 * @return false|string     false-失败，string-缓存数据
 */
if(!function_exists('get_cache')) {
    function get_cache($cachename)
    {
        $cachetime = 60 * 60;
        $CI = &get_instance();
        $path = $CI->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        if(file_exists($cache_path . $cachename) && filemtime($cache_path . $cachename) + $cachetime > time()) {
            return file_get_contents($cache_path . $cachename);
        } else {
            return FALSE;
        }
    }
}

/**
 * @title: 保存缓存的信息
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $cachename    string  缓存文件名称
 * @param $content      string  缓存数据
 * @return bool         bool    true-成功
 */
if(!function_exists('save_cache')) {
    function save_cache($cachename, $content)
    {
        $CI = &get_instance();
        $path = $CI->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        $cache_full_path = $cache_path . $cachename;
        file_put_contents($cache_full_path, $content);
        return TRUE;
    }
}


/* * *
 * ;;   //;
 *
 *      @param $filterparam ;
 *      @param suffix 传入的后缀;类似s 或者别的等;  
 *      @enumarray 传递的枚举数组和其对应的值;
 *      @rangearray 传递的范围的数组 
 *      @return boolean() 
 */
/**
 * @title: 检查传递的参数的信息范围是枚举数组或者是范围数组(也可以是两种组合)  仅判断地址栏传递的参数如果是传递的范围区间 array('1','100'),如果是枚举的话直接使用一个数组来写 array('abc','def','aaa');
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $filterparam      array   需要过滤的参数信息
 * @param $suffix           string  传入的后缀;类似s 或者别的等
 * @param $enumarray        array   传递的范围的数组
 * @param $rangearray       array   传递的范围的数组
 * @return bool             bool    true-成功，false-失败
 */
if(!function_exists('check_request_generate_cache')) {
    function check_request_generate_cache($filterparam, $suffix, $enumarray = false, $rangearray = false)
    {
        $flag = true;
        $getparam = $_GET;
        foreach ($getparam as $k => $v) {
            if(!in_array($k, $filterparam)) {
                return false;  //乱传递参数 直接false;
            }
            $temp = $k . $suffix;
            if(array_key_exists($temp, $enumarray)) {
                if(!in_array($v, $enumarray[$temp])) {
                    return false;
                }
            } else {
                if($v < $rangearray[$temp][0] || $v > $rangearray[$temp][1]) {
                    return false;   //如果键值不在枚举当中就在范围数组中了;
                }
            }
        }
        return true;
    }
}



