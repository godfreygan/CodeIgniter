<?php

/**
 * @title: 无限递归
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $data     array   需要递归的数组
 * @param $pid      int     父级ID
 * @param $level    int     级别
 * @return array    array   排好层级的数组
 */
function reclass($data = array(), $pid = 0, $level = 0)
{
    $level++;
    foreach ((array)$data as $k => $v) {
        if($v['parentid'] == $pid) {
            $v['level'] = $level;//查询层级;
            $newdata[] = $v;
            $newdatas = reclass($data, $v['id'], $level);
            if($newdatas) {
                $newdata = array_merge($newdata, $newdatas);//合并数组
            }
        }
    }

    if(isset($newdata)) {
        return $newdata;
    }
}

/**
 * @title: 无限递归查所有子类ID
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $data     array   需要递归的数组
 * @param $pid      int     父级ID
 * @return array    array   子类ID数组
 */
function get_reclassid($data = array(), $pid = 0)
{
    foreach ((array)$data as $k => $v) {
        if($v['parentid'] == $pid) {
            $newdata[] = $v['id'];
            $newdatas = get_reclassid($data, $v['id']);
            if($newdatas) {
                $newdata = array_merge($newdata, $newdatas);//合并数组
            }
        }
    }

    if(isset($newdata)) {
        return $newdata;
    } else {
        return array();
    }
}

/**
 * @title: 调试方法
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $str  string  要打印的变量
 */
function pe($str)
{
    header("Content-type: text/html; charset=utf-8");
    echo '<pre>';
    print_r($str);
    echo '</pre>';
    exit;
}

/**
 * @title: 调试方法
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $str  string  要打印的变量
 */
function de($str)
{
    header("Content-type: text/html; charset=utf-8");
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    exit;
}

/**、
 * @title: 获取首字母
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $str              string  字符串
 * @return mixed|string
 */
function initial($str)
{
    $firstchar_ord = ord(strtoupper($str{0}));
    if(($firstchar_ord >= 65 and $firstchar_ord <= 91) or ($firstchar_ord >= 48 and $firstchar_ord <= 57)) {
        return $str{0};
    }
    $s = iconv("UTF-8", "gb2312", $str);
    //$s=$str;
    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
    if($asc >= -20319 and $asc <= -20284) {
        return "A";
    }
    if($asc >= -20283 and $asc <= -19776) {
        return "B";
    }
    if($asc >= -19775 and $asc <= -19219) {
        return "C";
    }
    if($asc >= -19218 and $asc <= -18711) {
        return "D";
    }
    if($asc >= -18710 and $asc <= -18527) {
        return "E";
    }
    if($asc >= -18526 and $asc <= -18240) {
        return "F";
    }
    if($asc >= -18239 and $asc <= -17923) {
        return "G";
    }
    if($asc >= -17922 and $asc <= -17418) {
        return "H";
    }
    if($asc >= -17417 and $asc <= -16475) {
        return "J";
    }
    if($asc >= -16474 and $asc <= -16213) {
        return "K";
    }
    if($asc >= -16212 and $asc <= -15641) {
        return "L";
    }
    if($asc >= -15640 and $asc <= -15166) {
        return "M";
    }
    if($asc >= -15165 and $asc <= -14923) {
        return "N";
    }
    if($asc >= -14922 and $asc <= -14915) {
        return "O";
    }
    if($asc >= -14914 and $asc <= -14631) {
        return "P";
    }
    if($asc >= -14630 and $asc <= -14150) {
        return "Q";
    }
    if($asc >= -14149 and $asc <= -14091) {
        return "R";
    }
    if($asc >= -14090 and $asc <= -13319) {
        return "S";
    }
    if($asc >= -13318 and $asc <= -12839) {
        return "T";
    }
    if($asc >= -12838 and $asc <= -12557) {
        return "W";
    }
    if($asc >= -12556 and $asc <= -11848) {
        return "X";
    }
    if($asc >= -11847 and $asc <= -11056) {
        return "Y";
    }
    if($asc >= -11055 and $asc <= -10247) {
        return "Z";
    }

    return '';
}

/**
 * @title: 获取后缀
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $file     string  文件名称/路径下的文件名称
 * @return mixed
 */
function get_suffix($file = '')
{
    if(strpos($file, '.')) {
        $file = explode('.', $file);
        return $file[count($file) - 1];
    }
}

/**
 * @title: 返回2位小数
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $money
 * @return string
 */
function int2float($money)
{
    return sprintf("%01.2f", $money);
}

/**
 * @title: 格式化输出
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $bool bool    true-成功，false-失败
 * @param $stxt string  成功提示语
 * @param $ftxt string  失败提示语
 */
function echo_exit($bool, $stxt = '', $ftxt = '')
{
    $stxt = $stxt == '' ? '操作成功' : $stxt;
    $ftxt = $ftxt == '' ? '操作失败' : $ftxt;
    if($bool) {
        echo $stxt;
    } else {
        echo $ftxt;
    }
    exit();
}

/**
 * @title: 对象转数组
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $e        object  要转化的对象
 * @return array    array   转化后生成的数组
 */
function otoa($e)
{
    $e = (array)$e;
    foreach ($e as $k => $v) {
        if(gettype($v) == 'resource') {
            return array();
        }
        if(gettype($v) == 'object' || gettype($v) == 'array') {
            $e[$k] = (array)otoa($v);
        }
    }

    return $e;
}

/**
 * @title: 获取客户端IP地址
 * @author: godfrey.gan <g854787652@gmail.com>
 * @return string   string  IP地址
 */
function get_client_ip()
{
	$ipaddress = '';
	if(isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = '0.0.0.0';
	return $ipaddress;
}

/* 二维数组部分列 */
function getArrFiele($arr, $fields){
    $data = array();
    $count = count($fields);
    foreach($arr as $k=>$v){
        if($count > 1){
            foreach($fields as $v2){
                $data[$k][$v2] = $v[$v2];
            }
        }else{
            $data[] = $v[$fields[0]];
        }
    }
    return $data;
}

/**
 * @title: 字符串截取（所有字符长度都是1，gbk、utf-8通用）
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $str  string  要截取的字符串
 * @param $len  int     截取长度
 * @param $dot  string  不足长度填充字符串
 * @return string
 */
function cut($str, $len = 12, $dot = '...') {
    if (mb_strlen($str, "utf-8") <= ($len + 1)) {
        $str = $str;
    } else {
        $str = mb_substr($str, 0, $len, "utf-8") . $dot;
    }
    return $str;
}

if(!function_exists("array_column"))
{
    function array_column($array,$column_name)
    {
        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
    }
}

if(!function_exists("array_combine")) {
    function array_combine($keys, $values)
    {
        $result = array();
        foreach ($keys as $i => $k) {
            $result[$k][] = $values[$i];
        }
        array_walk($result, function (&$v) {
            $v = (count($v) == 1) ? array_pop($v) : $v;
        });
        return $result;
    }
}