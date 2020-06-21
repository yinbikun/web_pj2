<?php
namespace api\personal;
require_once "../index.php";
use api\common\DB;


if(!isset($_GET['uid'])) {
    errorJson('参数错误');
}
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 10;//默认一页十条数据
$uid = $_GET['uid'];

$db = new DB();
// 获取用户收藏的图片集
$all_list = $db->query("select img.* FROM " . TABLE_FAVOR . " as t right join ".TABLE_IMG." as img on t.imageID=img.ImageID WHERE t.UID=" . $uid);
$num = mysqli_num_rows($all_list);
if (!$num) {
    errorJson('您还没有收藏图片~');
}
$pageNum = ceil($num / $pageSize);

//计算起始位置
$start_page = ($page - 1) * $pageSize;

$sql="select img.* FROM " . TABLE_FAVOR . " as t right join ".TABLE_IMG." as img on t.imageID=img.ImageID WHERE t.UID='{$uid}' order by ImageID DESC limit {$start_page},{$pageSize}";

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
    successJson([]);
}
