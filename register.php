<?php
require_once "./include.php";
echo $_SESSION["openid"];
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>课程注册</title>
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<div class="register">账号注册</div>
	<div class="register_p">
		<form method='post' action="./reg_back.php" >
			<div class="cell">
				<div class="must">*</div>
				<p>姓名</p>
				<input type="text" name='name' class="reg_name">
			</div>
			<div class="cell">
				<div class="must">*</div>
				<p>学号</p>
				<input type="text" name='num'  class="reg_id">
			</div>
			<div class="cell">
				<p>班级</p>
				<input type="text" name="class" class="reg_class">
			</div>
			<div class="cell">
				<p>电话</p>
				<input type="text" name="phone" class="reg_number">
			</div>
			<div ><input type="submit" value="REGISTER" class="reg_register"></div>
		</form>
	</div>
</body>
</html>
