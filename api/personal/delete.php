<?php

namespace api\personal;

use api\common\Db;

require_once "../index.php";

$json = file_get_contents('php://input');
$params = json_decode($json, true);


if (!isset($params['id']) || !isset($params['uid'])) {
    errorJson('参数错误');
}
$id = $params['id'];
$uid = $params['uid'];


$db = new Db();
$is_has_auth=$db->fetchOne("select * from ".TABLE_IMG." where ImageID='{$id}' AND UID='{$uid}'");
if (!$is_has_auth){
    errorJson('没有权限操作');
}

$db->del(TABLE_FAVOR, ' ImageID =' . $id);
$db->del(TABLE_IMG, 'ImageID =' . $id);
successJson([], '图片删除成功');
