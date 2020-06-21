<?php

namespace api\home;

use api\common\Db;

require_once "../index.php";

$db = new DB();


$sql = "select ISO,Country_RegionName,fipsCountry_RegionCode,ISO3 from " . TABLE_COUNTRY." order by Country_RegionName asc";
$res = $db->fetchAll($sql);

if ($res) {
    successJson($res);
} else {
    errorJson("没有数据");
}
