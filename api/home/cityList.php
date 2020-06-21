<?php

namespace api\home;

use api\common\Db;

require_once "../index.php";

$db = new DB();

if (!isset($_GET['country'])){
    errorJson("请先选择country");
}
$country = $_GET['country'];

$sql = "select GeoNameID,AsciiName from " . TABLE_CITY." where Country_RegionCodeISO='{$country}' limit 300";
$res = $db->fetchAll($sql);

if ($res) {
    successJson($res);
} else {
    errorJson("没有数据");
}
