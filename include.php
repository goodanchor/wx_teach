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
echo 1;
