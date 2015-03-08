<?php
require_once "./include.php";

if(!empty($_POST))
	$arr['name'] = escape($_POST['name']);
	$arr['snum'] = escape($_POST['num']);
	$arr['phone'] = escape($_POST['phone']);
	$arr['classes'] = escape($POST['classes']);
	$arr['openid'] = escape($_SESSION['openid']);

if($arr['name']=='' OR $arr['snum']=='')
{
	$msg = 'name and num are required';
}
else if(!empty($arr['phone']) And strlen($arr['phone'])!=11)
{
	$msg = 'please fill in the right phone num';
}
else
{	
	$table = 'students';
	if(insert($table,$arr))
		$msg = 'success';
	else 
		$msg = 'failed';
}

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="./css/style_back.css">
</head>
<body>
	<div class="register">账号注册</div>
	<div class="register_p">
		<div class="reg_ok"><?php echo $msg?></div>
		<div class="reg_back">返回</div>
	</div>
</body>
</html>
