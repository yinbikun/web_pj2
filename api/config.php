<?php
//根目录
define('ROOT_PATH', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')));

//API目录
define("API_PATH", dirname(__FILE__ . "../"));


define("DB_HOST", "127.0.0.1");
define("DB_PORT", 3306);
define("DB_USER", "root");
define("DB_PWD", "tangrui123");
define("DB_CHARSET", "utf-8");
define("DB_NAME", "travel");

//数据表
const TABLE_USER = "traveluser";//用户

const TABLE_IMG = "travelimage";//图片

const TABLE_FAVOR = "travelimagefavor";//用户收藏

const TABLE_CITY="geocities";

const TABLE_COUNTRY="geocountries_regions";

