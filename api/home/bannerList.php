<?php
namespace api\home;

use api\common\Db;

require_once "../index.php";

$db = new DB();


$sql = "select * from " . TABLE_IMG . " ORDER BY RAND() limit 6 ";
$res = $db->fetchAll($sql);

if ($res) {
    successJson($res);
} else {
    errorJson("没有数据");
}
