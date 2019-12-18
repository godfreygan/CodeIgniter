<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 文件类修正
 *   how to use:
 *       $this->load->library('Files');
 *       $file = new Files();
 *       var_dump($file->listFile());
 */
class Files {
	
	
	public function listFile($path = '.') 
	{
		$data=array();
		$current_dir = opendir($path);    //opendir()返回一个目录句柄,失败返回false
		while(($file = readdir($current_dir)) !== false)
		{    //readdir()返回打开目录句柄中的一个条目
			$sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
			if($file == '.' || $file == '..')
			{
				continue;
		   }
		   else if(is_dir($sub_dir))
		   {    //如果是目录,进行递归
			   $data['dir'][] = $file;
			   $this->listFile($sub_dir);
		   }
		   else
		   {
			    if(!strpos($file,'.php'))
				{
					//如果是文件,直接输出
					$data['file'][] = $file;
				}
		   }
	   }
	   return $data;
	}
             
	
    /**
     * 建立文件夹
     *
     * @param string $aimUrl
     * @return viod
     */
    public function createDir($aimUrl) {
        $aimUrl = str_replace('', '/', $aimUrl);
        $aimDir = '';
        $arr = explode('/', $aimUrl);
        foreach ($arr as $str) {
            $aimDir .= $str . '/';
            if (!file_exists($aimDir)) {
                mkdir($aimDir);
            }
        }
    }
	
    /**
     * 建立文件
     *
     * @param string $aimUrl
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public function createFile($aimUrl, $overWrite = false) {
        if (file_exists($aimUrl) && $overWrite == false) {
            return false;
        } elseif (file_exists($aimUrl) && $overWrite == true) {
            $this->unlinkFile($aimUrl);
        }
        $aimDir = dirname($aimUrl);
        $this->createDir($aimDir);
        touch($aimUrl);
        return true;
    }
	
	/**
	* 写入文件
	*/
	public function writeFile($filename,$content='')
	{
		$this->createFile($filename,true);
		$handle = fopen($filename, 'a');
		fwrite($handle, $content);
		fclose($handle);
	}
	
	/**
     * 移动文件夹
     *
     * @param string $oldDir    操作源
     * @param string $aimDir    终点位置
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public function moveDir($oldDir, $aimDir, $overWrite = false) {
        $aimDir = str_replace('', '/', $aimDir);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
        $oldDir = str_replace('', '/', $oldDir);
        $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
        if (!is_dir($oldDir)) {
            return false;
        }
        if (!file_exists($aimDir)) {
            $this->createDir($aimDir);
        }
        @$dirHandle = opendir($oldDir);
        if (!$dirHandle) {
            return false;
        }
        while(false !== ($file = readdir($dirHandle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir($oldDir.$file)) {
                $this->moveFile($oldDir . $file, $aimDir . $file, $overWrite);
            } else {
                $this->moveDir($oldDir . $file, $aimDir . $file, $overWrite);
            }
        }
        closedir($dirHandle);
        return rmdir($oldDir);
    }
	
    /**
     * 移动文件
     *
     * @param string $fileUrl    操作源
     * @param string $aimUrl     终点位置
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public function moveFile($fileUrl, $aimUrl, $overWrite = false) {
        if (!file_exists($fileUrl)) {
            return false;
        }
        if (file_exists($aimUrl) && $overWrite = false) {
            return false;
        } elseif (file_exists($aimUrl) && $overWrite = true) {
            $this->unlinkFile($aimUrl);
        }
        $aimDir = dirname($aimUrl);
        $this->createDir($aimDir);
        rename($fileUrl, $aimUrl);
        return true;
    }
	
    /**
     * 删除文件夹
     *
     * @param string $aimDir
     * @return boolean
     */
    public function unlinkDir($aimDir)
	{
        $aimDir = ltrim($aimDir,'/');
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir.'/';		
        if (!is_dir($aimDir))
		{
            return false;
        }
        $dirHandle = opendir($aimDir);
        while(false !== ($file = readdir($dirHandle)))
		{
            if ($file == '.' || $file == '..')
			{
                continue;
            }
			
            if (!is_dir($aimDir.$file))
			{
                $this->unlinkFile($aimDir . $file);			
            }
			else
			{
                $this->unlinkDir($aimDir . $file);			
            }
        }
				
        closedir($dirHandle);
        return rmdir($aimDir);
    }
	
    /**
     * 删除文件
     *
     * @param string $aimUrl
     * @return boolean
     */
    public function unlinkFile($aimUrl) {
        if (file_exists($aimUrl)) {
            unlink($aimUrl);
            return true;
        } else {
            return false;
        }
    }
	
    /**
     * 复制文件夹
     *
     * @param string $oldDir    操作源
     * @param string $aimDir    终点位置
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public function copyDir($oldDir, $aimDir, $overWrite = false) {
        $aimDir = str_replace('', '/', $aimDir);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir.'/';
        $oldDir = str_replace('', '/', $oldDir);
        $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir.'/';
        if (!is_dir($oldDir)) {
            return false;
        }
        if (!file_exists($aimDir)) {
            $this->createDir($aimDir);
        }
        $dirHandle = opendir($oldDir);
        while(false !== ($file = readdir($dirHandle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir($oldDir . $file)) {
                $this->copyFile($oldDir . $file, $aimDir . $file, $overWrite);
            } else {
                $this->copyDir($oldDir . $file, $aimDir . $file, $overWrite);
            }
        }
        return closedir($dirHandle);
    }
	
    /**
     * 复制文件
     *
     * @param string $fileUrl       操作源
     * @param string $aimUrl        终点位置
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public function copyFile($fileUrl, $aimUrl, $overWrite = false) {		
        if (!file_exists($fileUrl)) {
            return false;
        }
        if (file_exists($aimUrl) && $overWrite == false) {
            return false;
        } elseif (file_exists($aimUrl) && $overWrite == true) {
            $this->unlinkFile($aimUrl);
        }
        $aimDir = dirname($aimUrl);
        $this->createDir($aimDir);
		$this->createFile($aimUrl);//创建文件
        copy($fileUrl, $aimUrl);
        return true;
    }
}
?>