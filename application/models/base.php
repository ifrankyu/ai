<?php
class baseModel
{
    private static $pdo = null;
    public function __construct() {}

    public static function getPDOInstance()
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $config = Yaf_Registry::get('config');
        try {
            self::$pdo = new PDO('mysql:host='
                . $config->database->host . ';dbname='
                . $config->database->dbname . ';charset=utf8',
                $config->database->username,
                $config->database->password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        return self::$pdo;
    }

    public function getAll($table, $params = [], $page = 1, $order = ' order by id desc')
    {
        if (!is_array($params)) {
            return false;
        }

        $keys = array_keys($params);
        $str  = '';
        if (count($keys) > 0) {
            foreach ($keys as $key) {
                # code...
                $str .= ' and ' . $key . '=:' . $key;
            }
        }
        $start = ($page - 1) * 10;
        $limit = " limit $start, 10";
        $sql   = 'select * from ' . $table . ' where 1=1' . $str . $order . $limit;
        echo $sql, "\n";
        try {
            $st = self::getPDOInstance()->prepare($sql);
            foreach ($params as $paramKey => $paramVal) {
                # code...
                $st->bindValue(':' . $paramKey, $paramVal);
            }
            $st->execute();
            $errorInfo = $st->errorInfo();
            $this->write_log($errorInfo);

            return $st->fetchAll();
        } catch (Exception $e) {
            $this->write_log($e->getMessage());
            return false;
        }
    }

    public function getOne($table, $params)
    {
        if (!is_array($params)) {
            return false;
        }

        $keys = array_keys($params);
        $str  = '';
        if (count($keys) > 0) {
            foreach ($keys as $key) {
                # code...
                $str .= ' and ' . $key . '=:' . $key;
            }
        }

        $limit = ' limit 1';
        $sql   = 'select * from ' . $table . ' where 1=1' . $str . $limit;
        // echo $sql, "\n";
        try {
            $st = self::getPDOInstance()->prepare($sql);
            foreach ($params as $paramKey => $paramVal) {
                # code...
                $st->bindValue(':' . $paramKey, $paramVal);
            }
            $st->execute();
            $errorInfo = $st->errorInfo();
            $this->write_log($errorInfo);

            return $st->fetch();
        } catch (Exception $e) {
            $this->write_log($e->getMessage());
            return false;
        }

    }

    public function insert($table, $params)
    {
        if (!is_array($params)) {
            return false;
        }

        // print_r($params);
        $keys = array_keys($params);
        // print_r($keys);

        $str = '';
        foreach ($keys as $key) {
            # code...
            $str .= $key . '=:' . $key . ',';
        }
        $str = substr($str, 0, strlen($str) - 1);

        $sql = 'insert into ' . $table . ' set ' . $str;
        // echo $sql, "\n";
        try {
            $st = self::getPDOInstance()->prepare($sql);
            foreach ($params as $paramKey => $paramVal) {
                # code...
                $st->bindValue(':' . $paramKey, $paramVal);
            }

            $effect    = $st->execute();
            $errorInfo = $st->errorInfo();
            $this->write_log($errorInfo);
            return $effect;
        } catch (Exception $e) {
            $this->write_log($e->getMessage());
            return false;
        }
    }

    public function write_log($errorInfo)
    {
        error_log(json_encode($errorInfo) . "\n", 3, APP_PATH . '/data/logs/mysql.log');
    }
}
