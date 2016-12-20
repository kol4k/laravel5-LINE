<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class MPCallbackController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		//
		$Channel_Access_Token = 'aFyGeQDnkNDX+ttD/Cfo2liDjORl86FouZCRitm4ypF+0EfhwTU1eiSUdT4O2icBC6QoHhewntLRYvstgf9Zj6d40Li2Pz+3CwiDKMhwfMiz6RiFwdbQx2IYmjiGUBOCkZHgxybbSUqzFI/sHvwHyAdB04t89/1O/w1cDnyilFU=';
		$json_string = file_get_contents('php://input');
		$json_object = json_decode($json_string);
		//メッセージのタイプを取得
		$types = $json_object->{"events"}[0]->{"message"}->{"type"};
		//メッセージ取得
		$message = $json_object->{"events"}[0]->{"message"}->{"text"};
		//ユーザID取得
		$User_id = $json_object->{"events"}[0]->{"source"}->{"userId"};
		//返信するためのReply_Tokenの取得
		$Reply_Token = $json_object->{"events"}[0]->{"replyToken"};
		if($message == "はい"){
			//自家製APIを叩く
			$channel = curl_init("https://api.line.me/v2/bot/profile/" . $User_id);
	    curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'GET');
	    curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($channel, CURLOPT_HTTPHEADER, array(
			  'Authorization: Bearer ' . $Channel_Access_Token
	    ));
	    $result = curl_exec($channel);
			//userの解析
			$json_object = json_decode($result);
			curl_close($channel);
			$displayName = $json_object->{"displayName"};
			$userId = $json_object->{"userId"};
			$statusMessage = $json_object->{"statusMessage"};

			$redis = \Illuminate\Support\Facades\Redis::connection();
			$redis->hset('UserList', $displayName, $userId);
			
			$reply = <<< EOM
CIAに問い合わせたら、こんな回答が来たわ
ユーザ名：{$displayName}
いまのひとこと：{$statusMessage}
これでいいか？
EOM;
			//返信
			$response_format_1 = [
			  "type" => "text",
			  "text" => "今からユーザ名とか送るで、あっとったら『おっけー』って答えて"
			];
			$response_format_2 = [
			  "type" => "text",
			  "text" => $reply
			];
			$post_data = [
			  "replyToken" => $Reply_Token,
			  "messages" => [$response_format_1, $response_format_2]
			];
			$channel = curl_init("https://api.line.me/v2/bot/message/reply");
			curl_setopt($channel, CURLOPT_POST, true);
			curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($channel, CURLOPT_POSTFIELDS, json_encode($post_data));
			curl_setopt($channel, CURLOPT_HTTPHEADER, array(
			  'Content-Type: application/json; charset=UTF-8',
			  'Authorization: Bearer ' . $Channel_Access_Token
			));
			$result = curl_exec($channel);
			curl_close($channel);
		}
		if($message == "おっけー"){
			//redisにデータを格納
			//$redis = \Illuminate\Support\Facades\Redis::connection();
			//hash
			//$add = $redis->hset('UserList', $displayName, $User_id);
			//$redis->set($displayName, $User_id);
			$response_format = [
			  "type" => "text",
			  "text" => "よしゃあ！"
			];
			$post_data = [
			  "replyToken" => $Reply_Token,
			  "messages" => [$response_format]
			];
			$channel = curl_init("https://api.line.me/v2/bot/message/reply");
			curl_setopt($channel, CURLOPT_POST, true);
			curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($channel, CURLOPT_POSTFIELDS, json_encode($post_data));
			curl_setopt($channel, CURLOPT_HTTPHEADER, array(
			  'Content-Type: application/json; charset=UTF-8',
			  'Authorization: Bearer ' . $Channel_Access_Token
			));
			$result = curl_exec($channel);
			curl_close($channel);
		}
		else {
			$redis->hdel('Key', $displayName);
			exit();
		}
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		//ユーザ情報取得
		$to = 'U7f41e0353d5c686cd62c27a6656a5772';
		$Channel_Access_Token = '8r2fCa0q0EykJeZm8BSoFoQaA9qETd9urj9rxaYgcgAphycTYL+OaNn9n2paQFp+aca4WLmQZzQRzAoNtP5IGSQ2HN/6NtZzY2Blzl9mNWd7xyew2FsFaKGUF3ig77AdXv+iAwwBubFcFPiEs6F4EAdB04t89/1O/w1cDnyilFU=';
		$channel = curl_init("https://api.line.me/v2/bot/profile/" . $to);
    curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($channel, CURLOPT_HTTPHEADER, array(
		  'Authorization: Bearer ' . $Channel_Access_Token
    ));
    $result = curl_exec($channel);
    print http_response_code();
    print ' ';
    print $result;
		$json_object = json_decode($result);
		$displayName = $json_object->{"displayName"};
		$userId = $json_object->{"userId"};
		$statusMessage = $json_object->{"statusMessage"};
    curl_close($channel);
		print $displayName;
		print "<br>";
		print $userId;
		print "<br>";
		print $statusMessage;
		print "<br>";
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}
