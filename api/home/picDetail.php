<?php

namespace api\home;

use api\common\Db;

require_once "../index.php";


if (!isset($_GET['id']) || !isset($_GET['uid'])) {
    errorJson('缺少参数');
}
$id = $_GET['id'];
$uid = $_GET['uid'];

$db = new DB();
$sql = "select t.*,user.UserName userName,city.AsciiName cityName,country.Country_RegionName countryName FROM " . TABLE_IMG . " as t ".
    " left join " . TABLE_USER . " as user on t.UID=user.UID ".
    " left join " . TABLE_CITY . " as city on t.CityCode=city.GeoNameID ".
    " left join " . TABLE_COUNTRY . " as country on t.Country_RegionCodeISO=country.ISO ".
    " WHERE ImageID=" . $id;

$res = $db->fetchOne($sql);

if ($res) {
    $is_collect = $db->fetchOne("select * FROM " . TABLE_FAVOR . " WHERE UID='{$uid}' AND ImageID='{$id}'");
    $collect_count = $db->fetchOne("select count(*) as count from " . TABLE_FAVOR . " WHERE ImageID='{$id}'");
    $res['collect_count'] = $collect_count ? (int)$collect_count['count'] : 0;
    $res['is_collect'] = $is_collect ? 1 : 0;
    successJson($res);
} else {
    errorJson("没有这条数据");
}
