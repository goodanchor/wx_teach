<?php
/**
 * wechat php test
 */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if(isset($_GET['echostr'])){
    $wechatObj->valid(); 
}
else{
    $wechatObj->responseMsg();
}


class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
    
    





    public function responseMsg()
    {
        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
        if(!empty($postStr)){
            $postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->msgType);

            $result = "";

            switch ($RX_TYPE)
            {
                case "event":
                $result = $this->receiveEvent($postObj);
                break;
                case "text":
                $result = $this->receiveText($postObj);
                break;
            }
            echo $result;
        }
        else{
            echo "";
            exit;
        }
    }


    private function receiveEvent($obj)
    {
        switch($obj->Event)
        {
            case "subscribe":
            $content =  "欢迎关注课表查询123";
            break;
        }
        $result = $this->transmitText($obj,$content);
        return $result;
    }

    private function receiveText($obj)
    {
        $keyword = trim($obj->Content);
        $url = "http://apix.sinaapp.com/weather/?appkey=".$object->ToUserName."&city=".urlencode($keyword);
        $output = file_get_contents($url);
        $content = json_decode($output,true);

        $result = $this->transmitNews($obj,$content);
        return $result;
    }

    
    private function transmitText($obj,$content)
    {
        if(!isset($content) || empty($content))
            return "";
        $textTpl ="
<xml>
<ToUserName><!CDATA[%s]></ToUserName>
<FromUserName><!CDATA[%s]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><!CDATA[text]></MsgType>
<Content><!CDATA[%s]></Content>
</xml>";
        $result = sprintf($textTpl,$obj->FromUserName,time(),$content);
        return $result;
    }

    private function transmitNews($obj,$newsArray)
    {
        if(!is_array($newsArray))
            return "";
        $itemTpl = "
  <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
  </item>
";
        $item_str = "";
        foreach($newsArray as $item)
        {
            $item_str.= sprintf($itemTpl,$item["Title"],$item['Description'],$item['PicUrl'],$item['Url']);
        }
        $newsTpl = "
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";
        $result = sprintf($newsTpl,$obj->FromUserName,$obj->ToUserName,time(),count($newsArray));
        return $result;
    }




    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }


    
}

?>
