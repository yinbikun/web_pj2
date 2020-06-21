<?php

namespace api\home;

use api\common\Db;

require_once "../index.php";


$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 10;//默认一页十条数据

//搜索
$title = isset($_GET['title']) ? $_GET['title'] : "";
$country = isset($_GET['country']) ? $_GET['country'] : "";
$city = isset($_GET['city']) ? $_GET['city'] : "";
$content=isset($_GET['content']) ? $_GET['content'] : "";
$random=isset($_GET['random']) ? $_GET['random'] : "";

$db = new DB();

$all_imgs_sql = "select * from " . TABLE_IMG;
$condition = " where 1=1 ";
if (!empty($city)) {
    $condition .= " AND CityCode ='{$city}'";
}
if (!empty($country)) {
    $condition .= " AND Country_RegionCodeISO ='{$country}'";
}

if (!empty($title)) {
    $condition .= " AND Title LIKE '%{$title}%'";
}

if (!empty($content)) {
    $condition .= " AND Content ='{$content}'";
}

$all_imgs_sql = $all_imgs_sql . $condition;

$all_imgs = $db->query($all_imgs_sql);
$num = mysqli_num_rows($all_imgs);
if (!$num) {
    errorJson('没有数据');
}
$pageNum = ceil($num / $pageSize);

//计算起始位置
$start_page = ($page - 1) * $pageSize;

$sql = "select * from " . TABLE_IMG;
$sql = $sql . $condition . " order by ImageID DESC limit {$start_page},{$pageSize}";

if(!empty($random)) {
    $sql = "select * from " . TABLE_IMG . " ORDER BY RAND() limit {$start_page},{$pageSize} ";
}
$res = $db->fetchAll($sql);

if ($res) {
    $data['list'] = $res;
    $data['pageInfo'] = [
        'totalNum' => (int)$num,
        'totalPage' => (int)$pageNum,
        'pageSize' => (int)$pageSize
    ];
    successJson($data);
} else {
    errorJson("没有数据");
}

