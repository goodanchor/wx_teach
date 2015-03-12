<?php
require_once "./include.php";

class Cac
{
    public $object = '';

    function __construct($object)
    {
	$this->object = $object; 
    }

    public function check($object)
    {
	//return $object->FromUserName;
        $openid = $object->FromUserName;
        $content = $object->Content;
        $content = escape($content);
        $sql = 'select * from students where openid = "'.$openid.'"';
	
	$row = fetch_one($sql);

	
        if($row['openid'])
        {
            $table = "students";
            $where = 'openid = "'.$openid.'"';

            if($content=="放弃")
            {
                del($table,$where);
                return $res = "请先登记";
            }
	    $i = $row['status'];
	    //return $row['status'];
            switch($i)
            {
                case 1:
                	if(!preg_match("/^U201[2-4]{1}[0-9]{5}$/",$content))
               		{
				$res = "请输入正确的学号,输入'放弃'取消本次操作";
			}
			else
			{
				$array = array("snum"=>$content,"status"=>2);
                		update($table,$array,$where);
                		$res = "您的学号是".$content."，请输入您的姓名,输入'放弃'取消本次操作";
			}
                	break;
	    
                case 2:
                	$array = array("name"=>$content,"status"=>3);
                	update($table,$array,$where);
                	$res = "您的姓名是".$content.",请输入您的班级,输入'放弃'取消本次操作";
                	break;
                case 3:
                	$array = array("classes"=>$content,"status"=>4);
                	update($table,$array,$where);
                	$res = "您的班级是".$content.",请输入您的手机号码,输入'放弃'取消本次操作";
                	break;
                case 4:
                	if (strlen($content)!=11 OR !preg_match("/^1[3-5,8]{1}[0-9]{9}$/",$content))
                   	{ 
				$res = "请输入正确的手机号,输入'放弃'取消本次操作";
			}
			else{                	
				$array = array("phone"=>$content,"status"=>5);
                		update($table,$array,$where);
                		$arr = fetch_one($sql);
                		$res = "您的学号是".$arr["snum"]."，姓名是".$arr["name"].",班级是".$arr["classes"].",电话是".$arr["phone"].",输入＇确认＇确认您的信息，输入放弃，取消本次操作";}
                	break;
                case 5:
		        if ($content=="确认")
		        {
		            $array = array("status"=>6);
		            update($table,$array,$where);
		            //$arr = fetch_one($sql);
		            $res = "恭喜您登记成功，这次就先这样吧";
		        }
		        else
		        {
		            $arr = fetch_one($sql);
		            $res = "您的学号是".$arr["snum"]."，姓名是".$arr["name"].",班级是".$arr["classes"].",电话是".$arr["phone"].",输入＇确认＇确认您的信息，输入放弃，取消本次操作";
		        }
                break;
		case 6:
			$arr = fetch_one($sql);
                        $res = "您的学号是".$arr["snum"]."，姓名是".$arr["name"].",班级是".$arr["classes"].",电话是".$arr["phone"];
		break;
            }
        }
        elseif($content=="登记")
        {
            $table = "students";
            $array = array("openid"=>$openid,"status"=>1);
            insert($table,$array);
            $res = "请输入学号";
        }
        else
        {
            $res = "请输入正确的指令";
        }
        return $res;
    }


}
