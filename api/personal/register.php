<?php
namespace api\personal;
require_once "../index.php";


use api\common\DB;


$json = file_get_contents('php://input');
$params=json_decode($json,true);

if (!isset($params['user_email']) || !isset($params['user_name']) || !isset($params['user_pwd'])) {
    errorJson('请输入完整的信息');
}

$user_email = $params['user_email'];
$user_name = $params['user_name'];
$user_pwd = $params['user_pwd'];
$user_pwd_again = $params['user_pwd_again'];


if($user_pwd_again !== $user_pwd) {
    errorJson('密码不一致');
}
unset($user_pwd_again);
$db = new DB();

$res = $db->add(TABLE_USER,[
    'Email'=>$user_email,
    'UserName'=>$user_name,
    'Pass'=>$user_pwd,
    'State'=>1,
    'DateLastModified'=>date("Y-m-d H:i:s"),
    'DateJoined'=>date("Y-m-d H:i:s")
]);
if($res) {
    successJson($res, '注册成功');
} else {
    errorJson('注册失败');
}
