<?php

namespace api\home;

use api\common\Db;

require_once "../index.php";

$db = new DB();
//热门国家
$country_sql = "select country.ISO,country.Country_RegionName name,count(*) count from " . TABLE_IMG .
    " as t left join " . TABLE_COUNTRY .
    " as country on t.Country_RegionCodeISO=country.ISO WHERE t.Country_RegionCodeISO is not NULL GROUP BY t.Country_RegionCodeISO ORDER BY count DESC limit 10";
$country_list = $db->fetchAll($country_sql);

//热门城市
$city_sql = "select city.GeoNameID id,city.AsciiName name,count(*) count from " . TABLE_IMG .
    " as t left join " . TABLE_CITY .
    " as city on t.CityCode=city.GeoNameID WHERE t.CityCode is not NULL GROUP BY t.CityCode ORDER BY count DESC limit 10";
$city_list = $db->fetchAll($city_sql);

//热门风格
$content_sql = "select t.Content,count(*) count from " . TABLE_IMG .
    " as t WHERE t.Content is not NULL GROUP BY t.Content ORDER BY count DESC limit 10";
$content_list = $db->fetchAll($content_sql);


$res['countryList'] = $country_list ? $country_list : [];
$res['cityList'] = $city_list ? $city_list : [];
$res['contentList'] = $content_list ? $content_list : [];
if ($res) {
    successJson($res);
} else {
    errorJson("没有数据");
}
