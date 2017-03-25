<?php

namespace core\lib;

use core\lib\Config;

class Model
{

    /* 数据库对象 */
    public $db = null;


    /*
     * 连接数据库
     * model constructor.
     */
    public function __construct($db = 'default')
    {
        $conf = Config::all('db');
        try {
            $this->db = new \PDO($conf[$db]['DSN'], $conf[$db]['USERNAME'], $conf[$db]['PASSWORD']);
        } catch (\PDOException $e) {
            E($e->getMessage());
        }

        return $this->db;
    }

    /* 防止克隆 */
    //private function __clone() {}


    /**
     * 功能:单例模式实例化数据库对象
     * @return object
     */
    /*
    public  function instance(){
        if(empty($this->db)){
            $this->db = new self();
        }
        return $this->db;
    }
    */


    /**
     * 功能:查询语句
     * @param $strSql 原始sql语句
     * @param string $queryModel [all(全部)|row（一条）]
     * @return array|mixed
     */
    public function query($strSql, $queryModel = 'all')
    {

        $result = array();
        $recordset = $this->db->query($strSql);

        $this->getPDOError();

        if ($recordset) {
            $recordset->setFetchMode(\PDO::FETCH_ASSOC);
            if ($queryModel == 'all') {
                $result = $recordset->fetchAll();
            } else {
                $result = $recordset->fetch();
            }
        }

        return $result;
    }

    /**
     * 功能:插入数据
     * @param $table 表名
     * @param $data 数据【关联数组】
     * @param bool|false $debug 【是否开启debug】
     * @return bool [插入结果]
     */
    public function insert($table, $data, $debug = false)
    {

        //检测字段是否对应
        $fields = $this->checkFields($table, $data);
        //拼装预处理语句
        $sql = '';
        foreach ($fields as $value) {
            $sql .= $value . '= ?,';
        }
        $sql = rtrim('insert into ' . $table . ' set ' . $sql, ',');

        if ($debug === true) $this->debug($sql);

        $stmt = $this->db->prepare($sql);

        for ($i = 1; $i <= count($data); $i++) {
            $stmt->bindParam($i, $data[$fields[$i - 1]]);
        }

        $res = $stmt->execute();
        $this->getPDOError();
        return $res;
    }

    /**
     * 功能:删除数据
     * @param string $table
     * @param string $where
     * @param bool|false $debug
     * @return int 影响的行数
     */
    public function delete($table, $where, $debug = false)
    {

        if (is_array($where)) {
            $wherestr = '';
            foreach ($where as $key => $value) {
                $wherestr .= ' ' . $key . '=' . $value . '&&';
            }
            $wherestr = rtrim($wherestr, '&&');
        }
        if (empty($where)) {
            E('error: where is null');
        }
        $sql = 'delete from ' . $table . ' where ' . $where;
        if ($debug === true) $this->debug($sql);
        $result = $this->db->exec($sql);
        $this->getPDOError();
        return $result;
    }

    /**
     * 功能:更新语句
     * @param $table
     * @param array $data
     * @param $where
     * @param bool|false $debug
     * @return int
     */
    public function update($table, array $data, $where, $debug = false)
    {

        $str = '';

        foreach ($data as $key => $value) {
            $str .= "{$key} = '" . $value . "',";
        }
        $str = rtrim($str, ',');
        $sql = 'update ' . $table . ' set ' . $str . ' where ' . $where;
        if ($debug === true) $this->debug($sql);

        $res = $this->db->exec($sql);
        $this->getPDOError();
        return $res;
    }

    /**
     * 功能:事务操作
     * @param array $arraySql = array('sql1','sql2');
     * @return bool
     */
    public function execTransaction(array $arraySql)
    {
        if (!is_array($arraySql) && empty($arraySql) == '') {
            P('params should be array and not null');
        }

        $this->db->beginTransaction();
        $res = true;
        foreach ($arraySql as $value) {
            $res = !empty($this->db->exec($value)) && $res;
            if ($res === false) {
                break;
            }
        }

        if ($res === true) {
            $this->db->commit();
            return true;
        } else {
            $this->db->rollBack();
            return false;
        }
    }

    /*
     * checkFields 检查指定字段是否在指定数据表中存在
     *
     * @param String $table
     * @param array $arrayField
     * return array
     */
    private function checkFields($table, $arrayFields)
    {
        $fields = $this->getFields($table);
        foreach ($arrayFields as $key => $value) {
            if (!in_array($key, $fields)) {
                E("Unknown column `$key` in field list.");
            }
        }
        return $fields;
    }

    /*
     * getFields 获取指定数据表中的全部字段名
     *
     * @param String $table 表名
     * @return array 数值索引
     */
    private function getFields($table)
    {
        $fields = array();
        $recordset = $this->db->query("SHOW COLUMNS FROM $table");
        $this->getPDOError();
        $recordset->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $recordset->fetchAll();
        foreach ($result as $rows) {
            $fields[] = $rows['Field'];
        }
        return $fields;
    }

    /**
     * getPDOError 捕获PDO错误信息
     */
    private function getPDOError()
    {
        if ($this->db->errorCode() != '00000') {
            $error = $this->db->errorInfo();
            E($error[2]);
        }
    }

    /**
     * 功能: 显示sql语句并停止
     * @param $str sql语句
     */
    private function debug($str)
    {
        dump($str);
        exit();
    }

}

