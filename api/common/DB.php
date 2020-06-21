<?php

namespace api\common;
require_once "../config.php";

class Db
{
    private $lin;//数据库连接

    function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->lin = mysqli_connect(DB_HOST, DB_USER, DB_PWD)
        or die("数据库连接失败Error:" . mysqli_error());
        mysqli_select_db($this->lin, DB_NAME) or die("指定数据库打开失败");
        mysqli_set_charset($this->lin, DB_CHARSET);
    }

    public function query($sql)
    {
        //            var_dump($sql);die;

        return mysqli_query($this->lin, $sql);
    }

    //一条记录
    public function fetchOne($sql, $type = MYSQLI_ASSOC)
    {
        $result = $this->query($sql);
        if (!$result) {
            echo "Error: " . mysqli_error($this->lin);
        }
        return mysqli_fetch_array($result, $type);
    }

    //所有结果
    public function fetchAll($sql, $type = MYSQLI_ASSOC)
    {
        try {
            $result = $this->query($sql);
            $rows = mysqli_fetch_all($result, $type);
            return $rows?:[];
        } catch (\Exception $exception) {
            errorJson($exception->getMessage());
        }
    }

    //新增
    public function add($table, $arr)
    {
        if (is_array($arr)) {
            $columns = '';
            $values = '';
            foreach ($arr as $k => $v) {
                $columns .= $k . ',';
                $values .= "'" . $v . "'" . ',';
            }
            $columns = trim($columns, ',');
            $values = trim($values, ',');

            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            $this->query($sql);
            return mysqli_insert_id($this->lin);
        }
    }

    //更新
    public function edit($table, $arr, $where)
    {
        if (is_array($arr)) {
            $modify = '';
            foreach ($arr as $key => $val) {
                $modify .= "`" . $key . "`='" . $val . "',";
            }
            $modify = trim($modify, ',');
            $sql = "UPDATE $table SET $modify WHERE $where";

            if ($this->query($sql)) {
                return mysqli_affected_rows($this->lin);
            }
            return false;
        }
    }

    //删除记录
    public function del($table, $where = '')
    {
        $sql = "delete from {$table}";
        $sql .= $where === '' ? '' : ' where ' . $where;
        $this->query($sql);
        return mysqli_affected_rows($this->lin);
    }

    function __destruct()
    {
        mysqli_close($this->lin);
    }
}
