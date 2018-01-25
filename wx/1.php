<?php 
header("content-type:text/html;charset=utf-8");
$post_obj = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'],'SimpleXMLElement',LIBXML_NOCDATA);
$wx_act = new wx_act();

switch($post_obj->MsgType){

	case 'text': $wx_act->response_text($post_obj);break;

	case 'event': $wx_act->response_event($post_obj);break;
}

class wx_act{
	public function response_text($post_obj){
		$con = '';
		switch ($post_obj->keyword) {

			case '你好': $con = '你好';break;

			case '干啥呢？': $con = '拉[便便]！';break;

			case '舒服吗？': $con = '你想干什么？?[阴险]！';break;

			case '你想干啥？': $con = '不要跟我说话--[怄火]！';break;

			default: $con = '不明白？？？[呲牙]';break;
		}

		$xml = '<xml>'
				 .'<ToUserName><![CDATA['.$post_obj->FromUserName.']]></ToUserName>'
				 .'<FromUserName><![CDATA['.$post_obj->ToUserName.']]></FromUserName>'
				 .'<CreateTime>'.time().'</CreateTime>'
				 .'<MsgType><![CDATA[text]]></MsgType>'
				 .'<Content><![CDATA['.$con.']]></Content>'
				.'</xml>';
				echo $xml;
	}

	public function response_event($post_obj){
		$con = '';
		switch ($post_obj->Event) {
			case 'CLICK':
					switch ($post_obj->EventKey) {
						case 'lgh':
							$con = '嗨!===我是张晓平===';
							break;
						case '呵呵':
							$con = '感谢您点赞[强][强][强]';
							break;
						default: $con = '不明白？？？[疑问][疑问][疑问]';break;
					}
					break;
			case 'VIEW':
					switch ($post_obj->EventKey) {
						case 'https://www.baidu.com':
							$con = '你好，欢迎进入百度';
							break;
						default: $con = '网址出错[擦汗]';break;
					}
					break;
			default: $con = '不明白？？？[擦汗][擦汗]';break;
		}

		$xml = '<xml>'
				 .'<ToUserName><![CDATA['.$post_obj->FromUserName.']]></ToUserName>'
				 .'<FromUserName><![CDATA['.$post_obj->ToUserName.']]></FromUserName>'
				 .'<CreateTime>'.time().'</CreateTime>'
				 .'<MsgType><![CDATA[text]]></MsgType>'
				 .'<Content><![CDATA['.$con.']]></Content>'
				.'</xml>';
				echo $xml;
	}
}