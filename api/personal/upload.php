<?php

namespace api\personal;

require_once "../index.php";


$file = $_FILES['file'];
$name = $file['name'];

$type = strtolower(substr($name, strrpos($name, '.') + 1)); //得到文件类型，并且都转化成小写
$allow_type = array('jpg', 'jpeg', 'gif', 'png'); //定义允许上传的类型

$ext = explode(".", $name);//拆分获取图片名
$ext = $ext[count($ext) - 1];//取图片的后缀名
//判断文件类型是否被允许上传
if (!in_array($type, $allow_type)) {
    //如果不被允许，则直接停止程序运行
    return;
}
//判断是否是通过HTTP POST上传的
if (!is_uploaded_file($file['tmp_name'])) {
    //如果不是通过HTTP POST上传的
    return;
}
$new_name = get_file_name(15) . '.' . $ext;
$upload_path = "../upload/" . $new_name; //上传文件的存放路径

//$serverImg_path = '/api/upload/'.$new_name;//读取文件路径
if (move_uploaded_file($file['tmp_name'], $upload_path)) {
    successJson($new_name, '图片上传成功');
} else {
    errorJson('图片上传失败');
}


//随机生成图片名
function get_file_name($len)
{
    $new_file_name = '';
    $chars = "1234567890qwertyuiopasdfghjklzxcvbnm";
    for ($i = 0; $i < $len; $i++) {
        $new_file_name .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $new_file_name;
}

function uploadImg($file)
{
    $url = 'https://img.abcyun.co/api/upload?image=' . $file . '&apiType=smms&token=a25c6f7f184bc0528fe21c325b4f2262 ';
    $json = get_Curl($url);
    $data = json_decode($json, true);
    return $data;
}

/**
 * curl网络api请求
 * @param $url
 * @return bool|string
 */
function get_Curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);  //设置访问的url地址
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不输出内容
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}