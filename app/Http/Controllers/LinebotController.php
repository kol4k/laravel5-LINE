<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LinebotController extends Controller {


	public function postIndex()
	{
		$signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);

		$http_client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('HXqTsJpyBHwrA/67xQ8ygLR8jxgENTvt5UywXQpnWwGG2US+Rsz/j6L4e5WNWSE4wiiUbrDvVB6rA5SAePsdfQXk3d/DGW+tzL6DQYRo0AlqZnf+IE2p4Qpz/pbIhiT7lDPGaO5MMKJQYr/8i79rIgdB04t89/1O/w1cDnyilFU=');
		$bot = new \LINE\LINEBot($http_client, ['channelSelect' => '5ae3f2ffbf39794c368e8b8c0873e4ed']);

		try {
			//LINEからのsignatureであれば処理を続行する
			$events = $bot->parseEventRequest($request->getContent(), $signature);
		}
		catch(exception $e) {
			print 'Bad Request!';
			exit();
		}
		
		//カルーセル型メッセージ
		$columns = [];
		foreach ($lists as $list) {
			# code...
			//カルーセルにつけるボタン
			$action = new UriTempleteActionBuilder("クリックして！", "http://api.rapsisv.mydns.jp");
			//カルーセルのカラム
			$column = new CarouselColumnTempleteBuilder("テストメッセージ", "テストだよ！", "",[$action]);
			$columns[] = $column;
		}

		//カラムの配列を結合してカルーセル作成
		$carousel = new CarouselColumnTempleteBuilder($columns);
		//カルーセルの作成およびメッセージの作成
		$carousel_message = new TempleteMessageBuilder("タイトルだよー", $carousel);

		//Confirm型のメッセージを作る
		$yes_post = new PostbackTempleteActionBuilder("はい", "page={$page}");
		//いいえボタン
		$no_post = new PostbackTempleteActionBuilder("いいえ", "page=-1");
		//confirmテンプレート
		$confirm = new ConfirmTempleteBuider("なんでもないよ", [$yes_post, $no_post]);
		//confirmメッセージを作る
		$confirm_message = new TempleteMessageBuilder("テスト", $confirm);

		//メッセージの送信
		$message = new MultiMessageBuilder();
		$message->add($carousel_message);
		$message->add($confirm_message);

		//replyトークンをつけて送る
		$res = $bot->replyMessage($event->getReplyToken(), $message);

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		print 'get';
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
