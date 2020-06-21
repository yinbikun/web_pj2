<?php

namespace api\personal;

require_once "../index.php";


use api\common\DB;

$json = file_get_contents('php://input');
$params = json_decode($json, true);
$db = new DB();

$id = $params['id'];//id
$title = $params['picTitle'];//名称
$desc = $params['picDesc'];//描述
$country = $params['picCountry'];//国家
$city = $params['picCity'];//城市
$url = $params['picURL']; //图片连接
$content = $params['picContent']; //图片风格

$uid = $params['uid'];

if (empty($uid) || empty($title) || empty($url) || empty($country) || empty($city)) {
    errorJson('请输入完整的信息!');
}
$_data = [
    'Title' => $title,
    'Description' => $desc,
    'CityCode' => $city,
    'Country_RegionCodeISO' => $country,
    'PATH' => $url,
    'Content' => $content,
    'UID' => $uid
];

if (!empty($id)) {
    //更新
    $res = $db->edit(TABLE_IMG, $_data, " ImageID='{$id}'");
} else {
    $res = $db->add(TABLE_IMG, $_data);
}


if ($res) {
    successJson($res, '保存成功');
} else {
    errorJson('保存失败');
}