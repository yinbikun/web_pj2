<?php

namespace api\personal;
require_once "../index.php";

use api\common\DB;

$json = file_get_contents('php://input');
$params=json_decode($json,true);

if (!isset($params['user_name']) || !isset($params['user_pwd'])) {
    errorJson('请输入用户名和密码');
}
$user_name = $params['user_name'];
$user_pwd = $params['user_pwd'];


$db = new DB();
$res = $db->fetchOne("select UID,Email,UserName,DateJoined,DateLastModified from ".TABLE_USER." where UserName = '{$user_name}' AND Pass='{$user_pwd}'");

if ($res) {
    successJson($res, '登录成功');
} else {
    errorJson('登录失败,用户名或密码错误');
}
