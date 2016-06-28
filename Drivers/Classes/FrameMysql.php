<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 14:26
 */
class FrameMysql extends Frame{

    public static $linkId;

    public function __construct($platForm = 'default') {
        return $this -> DBLink($platForm);

    }

    private function DBLink($platForm) {
        #获取配置文件
        switch ($platForm) {
            case 'default':
                $config = RC("db_config");
            break;
        }
        self :: $linkId = $this -> doConnect($config['host'], $config['username'], $config['password'], $config['database'], $config['charset']);
    }

    private function doConnect($host, $username, $password, $database, $dbcharset) {
        $instance = DriverMysql::getInstance();
        try {
            $dbSource = $instance -> connectDB($host, $username, $password, $database, $dbcharset);
        } catch (Exception $e) {
            #TODO
        }
        return $dbSource;
    }

    #获取一条记录（MYSQL_ASSOC，MYSQL_NUM，MYSQL_BOTH）
    public function get_one($sql,$result_type = MYSQLI_ASSOC) {
        FrameLogs::sql($sql, 'get_one');
        $query = $this->query($sql);
        $result =& mysqli_fetch_array($query,$result_type);
        return $result;
    }

    #查询
    public function query($sql) {
        $query = mysqli_query(self :: $linkId,$sql);
        return $query;
    }

    #获取全部记录
    public function get_all($sql,$result_type = MYSQLI_ASSOC) {
        FrameLogs::sql($sql, 'get_all');
        $query = $this->query($sql);
        $i = 0;
        $rt = array();
        while($row =& mysqli_fetch_array($query,$result_type)) {
            $rt[$i]=$row;
            $i++;
        }
        return $rt;
    }

    //插入
    public function insert($table,$dataArray, $replace = false) {
        $field = "";
        $value = "";
        if( !is_array($dataArray) || count($dataArray)<=0) {
            return false;
        }
        while(list($key,$val)=each($dataArray)) {
            $field .="$key,";
            $value .="'$val',";
        }
        $field = substr( $field,0,-1);
        $value = substr( $value,0,-1);
        $sql = "insert into $table($field) values($value)";
        if($replace) {
            $sql = "replace into $table($field) values($value)";
        }
        FrameLogs::sql($sql, 'insert');
        if(!$this->query($sql)) return false;
        return true;
    }

    #更新
    public function update( $table,$dataArray,$condition="") {
        if( !is_array($dataArray) || count($dataArray)<=0) {
            return false;
        }
        $value = "";
        while( list($key,$val) = each($dataArray))
            $value .= "$key = '$val',";
        $value .= substr( $value,0,-1);
        $sql = "update $table set $value where 1=1 and $condition";
        FrameLogs::sql($sql, 'update');
        if(!$this->query($sql)) return false;
        return true;
    }

    #删除
    public function delete( $table,$condition="") {
        if( empty($condition) ) {
            return false;
        }
        $sql = "delete from $table where 1=1 and $condition";
        FrameLogs::sql($sql, 'delete');
        if(!$this->query($sql)) return false;
        return true;
    }

    #返回结果集
    public function fetch_array($query, $result_type = MYSQLI_ASSOC){
        return mysqli_fetch_array($query, $result_type);
    }
    #获取记录条数
    public function num_rows($results) {
        if(!is_bool($results)) {
            $num = mysqli_num_rows($results);
            return $num;
        } else {
            return 0;
        }
    }

}
