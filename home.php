<?php
require_once "./include.php";
function login()
{
    if(isset($_GET['code']))
        $openid = get_user_openid($_GET['code']);
	$_SESSION['openid'] = $openid;
    if(!($row = check_stu_exists($openid)))
    {
        header('LOCATION:register.php');
    }
    else
        echo '您已经注册过了';
}


function get_user_openid($code)
{
    $appid = APPID;
    $appsecret = APPSECRET;
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
    $result = file_get_contents($url);
    $res = json_decode($result,TRUE);
    return $res['openid'];
}

function check_stu_exists($openid)
{
    $openid = escape($openid);
    $sql = "select * from students where openid = '".$openid."'";
    if($row = fetch_one($sql))
        return $row;
    return FALSE;
}

login();
