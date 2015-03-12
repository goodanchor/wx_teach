<?php
require_once "../home.php";
function signin($obj)
{
    $openid = $obj->FromUserName;
    if(!check_stu_exists($openid))
    {
        $msg = '您还没有注册，请点击个人中心先注册课程';
    }
    else
    {
        $msg = '签到成功';
    }
    return $msg;
}







