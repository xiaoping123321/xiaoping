<?php
header("content-type:text/html;charset=utf-8");
$app_id = 'wx5da033d3fa3c3489';
$app_secret = 'a2f6499a1a930c80d069def56e141fba';
$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$app_secret;
$token_arr = json_decode(curl_send($url),true);

$token = $token_arr['access_token'];
set_menu($token);
function set_menu($token){
	$url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
	$menu_arr = array(
			'button' => array(
					array(
							'type' => 'click',
							'name' => '张晓平',
							'key' => 'lgh',
						),
					array(
							'name' => '二级菜单',
							'sub_button' => array(
									array(
											'type' => 'view',
											'name' => '搜索',
											'url' => 'https://www.baidu.com',
										),
									array(
											'type' => 'click',
											'name' => '点赞',
											'key' => '呵呵',
										),
								)
						)
				)
		);
	//var_dump($menu_arr);die;
		$menu_json = json_encode($menu_arr,JSON_UNESCAPED_UNICODE);
		echo curl_send($url,1,$menu_json);
}

function curl_send($url,$is_post=0,$data=''){
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	if($is_post){
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	}
	$con = curl_exec($ch);
	curl_close($ch);
	return $con;
}
function Send()
{
         // 接收数据
         $post =  file_get_contents('php://input');
         file_put_contents('post_'.rand(11,99).'.log', $post);

         $arr = (array)simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
         file_put_contents('arr_'.rand(11,99).'.log', json_encode($arr));

        // 类型
        $type = $arr['MsgType'];
        switch ($type) {
          case 'event':
             $res = Even($arr);
            break;
          case 'text':
             $res = atext($arr);
            break;
          
        }
        echo $res;
}

// 类型判断
function Even($arr)
{
    switch ($arr['Event']) {
      case 'subscribe':
          $str = Guan($arr);
        break;
      case 'text':
          $str = atext($arr);
        break;
      case 'LOCATION':
           aadd($arr);
        break;
    }
    echo $str;
}

//关注消息
function  Guan($arr)
{
    $str = "<xml>
<ToUserName><![CDATA[".$arr['FromUserName']."]]></ToUserName>
<FromUserName><![CDATA[".$arr['ToUserName']."]]></FromUserName>
<CreateTime>".time()."</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[欢迎你]]></Content>
</xml>";

file_put_contents('res_'.rand(11,99).'.log',$str);
echo $str;


}