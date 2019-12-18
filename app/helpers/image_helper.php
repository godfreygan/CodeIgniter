<?php

/**
 * @title: 创建缩略图
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $img  string  图片路径
 * @param $w    integer 宽度
 * @param $h    integer 高度
 * @param $hz   string  格式
 * @param $type bool
 */
function create_thumb($img, $w, $h, $hz = 'jpg', $type = false)
{
    $_CI = &get_instance();

    $img = ltrim($img, '/');
    if (file_exists($img)) {
        $_CI->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $img;
        $config['new_image'] = $img . '_' . $w . '-' . $h . '.' . $hz;
        $config['create_thumb'] = true;
        $config['maintain_ratio'] = true;
        $config['thumb_marker'] = '';
        $config['width'] = $w;
        $config['height'] = $h;

        if ($type == true) {
            $config['master_dim'] = 'auto';
        }
        $_CI->image_lib->initialize($config);
        $_CI->image_lib->resize();
        $_CI->image_lib->clear();
    }
}

/**
 * @title: png转jpg
 * @author: godfrey.gan <g854787652@gmail.com>
 * @param $path     string  图片路径
 * @return string   string  新图片路径
 */
function png2jpg($path)
{
    $path = ltrim($path, '/');
    if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) == 'jpg') {
        return '/' . $path;
    }
    $path_jpg = $path . '.jpg';
    if (file_exists($path_jpg)) {
        return '/' . $path_jpg;
    }

    if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) != 'png') {
        return '';
    }
    $tmp = imagecreatefrompng($path);
    $w = imagesx($tmp);
    $y = imagesy($tmp);
    $simg = imagecreatetruecolor($w, $y);
    $bg = imagecolorallocate($simg, 255, 255, 255);
    imagefill($simg, 0, 0, $bg);
    imagecopyresized($simg, $tmp, 0, 0, 0, 0, $w, $y, $w, $y);
    imagejpeg($simg, $path_jpg);
    if (file_exists($path_jpg)) {
        return '/' . $path_jpg;
    } else {
        return '';
    }
}