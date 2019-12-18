<?php
/**
 ***********************************************************************************************************************
 * curl封装类库
 ***********************************************************************************************************************
 */
class Curl
{
    /**
     * @param $url
     * @param array $data
     * @param array $options
     * @return mixed
     */
    public function get($url, $data = array(), $options = array())
    {
        if(empty($data)) {
            return $this->get_curl($url, array(), $options);
        }
        // 拼接参数到url中
        $url = preg_match('/[?]/', $url) ? rtrim($url, '&') . '&' . http_build_query($data) : rtrim($url, '?') . '?' . http_build_query($data);
        return $this->get_curl($url, array(), $options);
    }


    /**
     * @param $url
     * @param array $data
     * @param array $options
     * @return mixed
     */
    public function post($url, $data = array(), $options = array())
    {
        return $this->get_curl($url, $data, $options);
    }


    /**
     * @param $url
     * @param array $data
     * @param array $options
     * @return mixed|null
     */
    public function get_curl($url, $data = array(), $options = array())
    {
        if(empty($url)) {
            return null;
        }

        // 自动添加HTTP
        if(!preg_match('/^http[s]?[:]\/\/(.*)/', $url)) {
            $url = 'http://' . $url;
        }

        // 处理$options
        if(!empty($options)) {
            foreach($options as $key => $option) {
                $key = preg_replace('/(CURLOPT_|curlopt_)/', '', $key);
                unset($options[$key]);
                $options[strtoupper($key)] = $option;
            }
        }

        // 初始化
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // 设置HTTPHEADER
        if(!empty($options['HTTPHEADER'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['HTTPHEADER']);
        }

        // 设置超时时间 默认5秒
        $timeout = !empty($options['TIMEOUT']) ? intval($options['TIMEOUT']) : 10;
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        // 设置只解析IPV4
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 处理dns秒级信号丢失问题
        curl_setopt($ch, CURLOPT_NOSIGNAL, true);

        // 设置COOKIE
        if(!empty($options['COOKIE'])) {
            curl_setopt($ch, CURLOPT_COOKIE, $options['COOKIE']);
        }

        // POST请求
        if(!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? http_build_query($data) : $data);
        }

        // 设置头部
        if(!empty($options['HEADER'])) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        // 设置其他参数
        $dcs = get_defined_constants(true);
        foreach($options as $option => $val) {
            if(!in_array($option, array('HEADER', 'COOKIE', 'TIMEOUT', 'HTTPHEADER'))) {
                $opt = 'CURLOPT_' . $option;
                $opt_defined = isset($dcs['curl'][$opt]) ? $dcs['curl'][$opt] : 0;
                if($opt_defined != 0) {
                    curl_setopt($ch, $opt_defined, $val);
                }
            }
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}