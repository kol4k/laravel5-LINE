<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AmazonDashButtonController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($mes)
	{
		if($mes == ''){
			$message = 'GETリクエストにオプションがありませんでした。';
		}
		else{
			$message = $mes;
		}
		//To
		$to = 'U7f41e0353d5c686cd62c27a6656a5772';
		//Channel_Access_Token
		//TLTF
		$Channel_Access_Token = 'HXqTsJpyBHwrA/67xQ8ygLR8jxgENTvt5UywXQpnWwGG2US+Rsz/j6L4e5WNWSE4wiiUbrDvVB6rA5SAePsdfQXk3d/DGW+tzL6DQYRo0AlqZnf+IE2p4Qpz/pbIhiT7lDPGaO5MMKJQYr/8i79rIgdB04t89/1O/w1cDnyilFU=';

		//https://api.raspisv.mydns.jp/v1/amazon/dash

		$response_format = [
		  "type" => "text",
		  "text" => $message
		];

		$post_data = [
			"to" => $to,
		  "messages" => [$response_format]
		];

		//postデータ
		$channel = curl_init("https://api.line.me/v2/bot/message/push");
		curl_setopt($channel, CURLOPT_POST, true);
		curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($channel, CURLOPT_POSTFIELDS, json_encode($post_data));
		curl_setopt($channel, CURLOPT_HTTPHEADER, array(
		  'Content-Type: application/json; charset=UTF-8',
		  'Authorization: Bearer ' . $Channel_Access_Token
		));

		$result = curl_exec($channel);
		print http_response_code();
		print ' ';
		print $result;
		curl_close($channel);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		//
		//accessTokenの設定
		$Channel_Access_Token = 'HXqTsJpyBHwrA/67xQ8ygLR8jxgENTvt5UywXQpnWwGG2US+Rsz/j6L4e5WNWSE4wiiUbrDvVB6rA5SAePsdfQXk3d/DGW+tzL6DQYRo0AlqZnf+IE2p4Qpz/pbIhiT7lDPGaO5MMKJQYr/8i79rIgdB04t89/1O/w1cDnyilFU=';

		$results_1 = '返信メッセージです';
		//ユーザからのメッセージを受信
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

		//タイプのチェックフラグ
		$type_check = 0;

		//メッセージ以外は無視
		if($types != "text"){
		  exit();
		}

		$response_format = [
		  "type" => "text",
		  "text" => $results_1
		];

		//userIdの確認
		$response_data_1 = [
		  "type" => "text",
		  "text" => $User_id
		];

		$post_data = [
		  "replyToken" => $Reply_Token,
		  "messages" => [$response_format]
		];


		/*
		function new_userid_add(){
		  $entry_name = [
		    "type" => "text",
		    "text" => "あなたの名前を入力してください．"
		  ];

		  $post_data = [
		    "replyToken" => $Reply_Token,
		    "messages" => [$entry_name]
		  ];

		}
		*/



		//返信用のpostデータの送信先
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
