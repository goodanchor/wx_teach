<?php

header('content-type:text/html;charset=utf-8');
session_start();

error_reporting(E_ERROR||E_WARNING||E_NOTICE);

define('ROOT',dirname(__FILE__));

set_include_path('.'.PATH_SEPARATOR.ROOT.'/lib'.PATH_SEPARATOR.ROOT.'/config'.PATH_SEPARATOR.ROOT.'/core'.PATH_SEPARATOR.get_include_path());

require_once 'configs.php';
require_once 'mysql.func.php';
//require_once 'sign_in.func.php';

connect();


/*$table = "students";
$array = array("openid"=>1,"status"=>1);
$sql = 'select * from students where openid = "1" and status = 1';
$row = fetch_one($sql);
echo $row['status'];*/

