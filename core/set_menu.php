<?php
define('APPID','wx8924b2326053f004');
define('APPSECRET','cefcd6a58e6aa557f3c33715dd3ab970');
date_default_timezone_set('Asia/Shanghai');

class SetMenu
{
    public function index()
    {
        print_r($this->read_access_token()) ;
    }

    private function read_access_token()
    {
     
        $filename = './access_token';
        if(!file_exists($filename))
            echo 0;
        $file = fopen($filename,'r');
        $res = fread($file,filesize($filename));
        $res = json_decode($res,TRUE);
        if(empty($res))
           $this->get_access_token();
        $dt = time()-$res['time'];
        if($dt>7000)
            $this->get_access_token();
        return $res['access_token'];
    }

    private function get_access_token()
    {
        $appid = APPID;
        $appsecret = APPSECRET;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $result = file_get_contents($url);
        $res = json_decode($result,TRUE);
        $res['time'] = time();
        $res = json_encode($res,TRUE);
        $this->save_access_token($res);
    }

    public function save_access_token($res)
    {
        //print_r($res);
        $filename = './access_token';
        $file = fopen($filename,"w") or die('failed to open file');
        fwrite($file, $res);
        fclose($file);
        $this->read_access_token();
    }

    private function set_menu()
    {
        $access_token = $this->read_access_token();
         $data = '{
              "button":[
              {
               	   "type":"view",
                   "name":"签到",
                   "url" :"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx8924b2326053f004&redirect_uri=http://www.6not6.com/weixin/home.php&response_type=code&scope=snsapi_base&state=1#wechat_redirect" 
               },
              {
               	   "type":"click",
                   "name":"答题",
                   "key" :"1"
               },
               {
                   "name":"个人中心",
                   "sub_button":[
                    {
                       "type":"view",
                       "name":"我的成绩",
                       "url":"http://www.baidu.com"
                    },
                    {
                       "type":"view",
                       "name":"注册课程",
                       "url":"http://www.baidu.com"
                    }]
               }]
         }';
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $res = $this->https_request($url,$data);
        echo $res;
    }

    public function send_http_post($url,$data)
    {
        $data = http_build_query($data);

        $options = array(
            'http'=>array(
                'method'=>'POST',
                'header'=>'Content-type:application/x-www-form-urlencodedrn'.'Content-Length:'.strlen($data).'rn',
                'content'=>$data
                )
        );
        $context = stream_context_create($options);
        $res = file_get_contents($url,FALSE,$context);
        return  $res;
    }



    public function https_request($url,$data=NULL)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

}


$setme = new Setmenu;
$setme -> index();

