<?php

namespace api\personal;

use api\common\Db;

require_once "../index.php";


$json = file_get_contents('php://input');
$params = json_decode($json, true);

if (!isset($params['imgId']) || !isset($params['uid'])) {
    errorJson('参数错误');
}
$imgId = $params['imgId'];
$uid = $params['uid'];


$db = new DB();

$is_collect = $db->fetchOne("select * from " . TABLE_FAVOR . " where UID='{$uid}' AND ImageID='{$imgId}'");

//如果已经收藏了，就取消收藏，否则就是增加收藏

if ($is_collect) {
    $res = $db->del(TABLE_FAVOR, "FavorID=" . $is_collect['FavorID']);
} else {
    $res = $db->add(TABLE_FAVOR, [
        'UID' => $uid,
        'ImageID' => $imgId,
    ]);
}


if ($res) {
    $is_collect = $db->fetchOne("select * FROM " . TABLE_FAVOR . " WHERE UID='{$uid}' AND ImageID='{$imgId}'");
    $collect_count = $db->fetchOne("select count(*) as count from " . TABLE_FAVOR . " WHERE ImageID='{$imgId}'");

    $data['collect_count'] = $collect_count ? (int)$collect_count['count'] : 0;
    $data['is_collect'] = $is_collect ? 1 : 0;
    successJson($data, '成功');
} else {
    errorJson('操作失败');
}