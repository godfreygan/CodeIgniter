<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Upload_Ftp {

    private $hostname;
    private $username;
    private $password;
    private $port;
    private $passive = true;
    private $conn_id = false;

    /**
     * 使用方法 先链ftp服务器  $this->load->library('Upload_ftp');
     * 然后调用对应的上传单个文件夹 $this->upload_ftp->upload_file($path)
     * 然后调用对应的上传单个文件   $this->upload_ftp->upload_one_file($file)
     */
    function __construct() {

        /* 从配置里获取FTP账户参数 */
        $CI = &get_instance();
        $CI->load->config('website');
        $ftp = $CI->config->item('ftp');
        $this->hostname = $ftp['hostname'];
        $this->username = $ftp['username'];
        $this->password = $ftp['password'];
        $this->port = $ftp['port'];

        set_time_limit(0);
        //初始化需要保存的文件夹以及文件; 以及所需要的修改的头文件;
        $this->dirs = array();
        $this->files = array();
        $this->error_message = array();
        $this->dst = '/' . $_SERVER["SERVER_NAME"];
    }

    function __destruct() {
        @ftp_close($this->conn_id);
    }

    /**
     * ftp连接;
     * 传递的参数应该是array('hostname'=>'','username'=>'','password'=>'','port'=>'');
     */
    public function connect($config = array()) {
        if (count($config) > 0) {
            $this->_init($config);
        }

        if (($this->conn_id = @ftp_connect($this->hostname, $this->port)) === FALSE) {
            exit('无法连接ftp服务器');
        }

        if (@ftp_login($this->conn_id, $this->username, $this->password) == false) {
            exit('用户名或密码错误');
        }

        if ($this->passive == TRUE) {
            ftp_pasv($this->conn_id, TRUE);
        }

        return true;
    }

    /**
     *  将你需要上传到ftp地址的所有的文件和文件夹遍历出来;--按照数组的方式取出来;
     */
    private function listDir($dirname) {
        $dir = opendir($dirname);
        while (($file = readdir($dir)) != false) {
            if ($file == "." || $file == "..") {
                continue;
            }
            if (is_dir($dirname . "/" . $file)) {
                array_push($this->dirs, $dirname . "/" . $file);
                $this->listDir($dirname . "/" . $file);
            } else {
                array_push($this->files, $dirname . "/" . $file);
            }
        }
        closedir($dir);
    }

    /**
     * ftp上传所需要的文件;(此方法默认支持zip --jpg--gif--exe--swf) 若其他格式第二个参数请选择 FTP_ASCII
     */
    public function upload_file($path, $mode = FTP_BINARY) {
        if (!file_exists($path)) {
            exit($path . '文件夹不存在');
        }
        $this->listDir($path);
        $this->mkdir_dir($path);
        //开始上传ftp所需要的文件;
        foreach ($this->files as $f) {
            if (!ftp_put($this->conn_id, $this->dst . substr($f, 1), $f, $mode)) {
                $this->error_message[] = $f;
            }
        }

        if (empty($this->error_message)) {
            return true;
        } else {
            return $this->error_message;
        }
    }

    /**
     *  ftp 上传单独一个文件信息;
     *  return boolen;
     */
    public function upload_one_file($file, $mode = FTP_BINARY) {
        if (!file_exists($file)) {
            exit($file . '文件不存在');
        }
        $path = pathinfo($file, PATHINFO_DIRNAME);

        if (ftp_size($this->conn_id, $this->dst) == -1) {
            @ftp_mkdir($this->conn_id, $this->dst . substr($path, 1));
        }

        $res = ftp_put($this->conn_id, $this->dst . substr($file, 1), $file, $mode);

        return $res;
    }

    /**
     * ftp上创建所需要创建的对应的文件夹;
     */
    public function mkdir_dir($path) {
        //传递的文件夹;
        if (ftp_size($this->conn_id, $this->dst) == -1) {
            @ftp_mkdir($this->conn_id, $this->dst . substr($path, 1));
        }
        ftp_chdir($this->conn_id, $this->dst);
        foreach ($this->dirs as $d) {
            if (ftp_size($this->conn_id, $this->dst . substr($d, 1)) == -1) {
                @ftp_mkdir($this->conn_id, $d);
            }
        }
    }

    /**
     *  配置文件初始化 ;
     */
    private function _init($config = array()) {
        foreach ($config as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }
        //特殊字符过滤
        $this->hostname = preg_replace('|.+?://|', '', $this->hostname);
    }

    /**
     * test_demo
     */
    public function test_upload_file_to_ftp() {
        $this->connect();
        $this->upload_file('./data/update_files/5/zip/version_20160805114136');
    }

}
