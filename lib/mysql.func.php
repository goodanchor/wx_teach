<?php


/*连接数据库*/
function connect()
{
    $conn = mysql_connect(DB_HOST,DB_USER,DB_PSW) or die('数据库连接失败'.mysql_error());
    mysql_set_charset(DB_CHARSET);
    mysql_select_db(DB_NAME) or die('数据库打开失败');
    return $conn;
}
/*
 *插入数据库
 *@parms $table 数据库表名　字符串
 *@parms $array 要插入的字段数据 数组
 */
function insert($table,$array)
{
    $keys = join(',',array_keys($array));
    $values = '"'.join('","',array_values($array)).'"';
    $sql = 'insert into '.$table.' ('.$keys.')'.' values ('.$values.')';
    //echo $sql;
    mysql_query($sql);
    return mysql_insert_id();
}
/*
 *删除操作
 *@parms $table 表名　字符串
 *@parms $where = '字段＝字段值' 要删除的条件　string
 */


function del($table,$where)
{
    $where = ($where == NULL?NULL:$where);
    $sql = 'delete from '.$table.' where '.$where;
    mysql_query($sql);
    return mysql_affected_rows();
}



/*
 *更新数据库
 *@parms $table 数据库表名　字符串
 *@parms $array 要更新的字段数据 数组
 *@parms $where = '字段＝字段值' 要删除的条件　string
 */
function update($table,$array,$where)
{
    $str ='';
    foreach($array as $key => $value)
    {
        if($str=='')
        {
            $str = $key."='".$value."'";
        }
        else
        {
            $str = $str.','.$key.'="'.$value.'"';
        }
    }
    $sql = 'update '.$table.' set '.$str.' where '.$where;
    mysql_query($sql);
    return mysql_affected_rows();
}

/*
   查询一条
 */
function fetch_one($sql,$result_type=MYSQL_ASSOC)
{
    $query = mysql_query($sql);
    if($query && mysql_num_rows($query)>0){
	$row = mysql_fetch_array($query,$result_type=MYSQL_ASSOC);
        return $row;
    }
    return FALSE;
    
}
/*查询所有*/
function fetch_all($sql)
{
    $query = mysql_query($sql);
    if(!$query)
        return FALSE;
    while ($row = mysql_fetch_array($query)){
        $rows[] = $row;
    }
    return $rows;
}
//数据基本过滤和转义
function escape($string)
{
    $string = (string)$string;
    $string = trim($string);
    $string = mysql_real_escape_string($string);
    return $string;
}
