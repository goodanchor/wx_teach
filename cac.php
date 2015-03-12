<?php
require_once "include.php";
class Cac
{
    public function check($object)
    {
        $openid = $object->FromUserName;
        $content = $object->Content;
        $content = escape($content);
        $sql = "select * from students where openid = ".$openid;
        if(fetch_one($sql))
        {
            $table = "students";
            $where = "openid = $openid";
            if($content=="放弃")
            {
                del($table,$where);
                return $res = "请先登记";
            }
            switch($row["status"])
            {
                case 0:
                if(!preg_metch("/^U201[2-4]{1}[0-9]{5}$/",$content))
                    return　$res = "请输入正确的学号,输入'放弃'取消本次操作";
                $array = array("snum"=>$content,"status"=>1);
                update($table,$array,$where);
                $res = "您的学号是$content，请输入您的姓名,输入'放弃'取消本次操作";
                break;
                case 1:
                $array = array("name"=>$content,"status"=>2);
                update($table,$array,$where);
                $res = "您的姓名是$content,请输入您的班级,输入'放弃'取消本次操作";
                break;
                case 2:
                $array = array("classes"=>$content,"status"=>3);
                update($table,$array,$where);
                $res = "您的班级是$content,请输入您的手机号码,输入'放弃'取消本次操作";
                break;
                case 3:
                if (strlen($content)!=11 OR !preg_match("/^1[3-5,8]{1}[0-9]{9}$/",$content))
                    return  $res = "请输入正确的手机号,输入'放弃'取消本次操作";
                $array = array("phone"=>$content,"status"=>4);
                update($table,$array,$where);
                $arr = fetch_one($sql);
                $res = "您的学号是$arr["snum"]，姓名是$arr["name"],班级是$arr["classes"],电话是$arr["phone"],输入＇确认＇确认您的信息，输入放弃，取消本次操作";
                break;
                case 4:
                if ($content=="确认")
                {
                    $array = array("status"=>5);
                    update($table,$array,$where);
                    $arr = fetch_one($sql);
                    $res = "恭喜您登记成功，这次就先这样吧";
                }
                else
                {
                    $arr = fetch_one($sql);
                    $res = "您的学号是$arr["snum"]，姓名是$arr["name"],班级是$arr["classes"],电话是$arr["phone"],输入＇确认＇确认您的信息，输入放弃，取消本次操作";
                }
                break;
            }
        }
        elseif($content=="登记")
        {
            $table = "students";
            $array = array("openid"=>$openid,"status"=>0);
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