<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;
//use LINE\LINEBot\Message\RichMessage\Markup;

class MessagingApiController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		require_once '/laravel/app/api/vendor/autoload.php';

		$signature = $request()->headers->get(HTTPHeader::LINE_SIGNATURE);

		$bot = new \LINE\LINEbot(new \LINE\LINEBot\HTTPClient\CurlHTTPClient('4cc76fff942efe19bc633961b3ee34ca'),[
			'channelSecret' => 'NTEvgaLM0JTcVePz+Bq92w+TPMqOnBxbztBKNz6hqGFNbSDPb1G4M2rikEat9fdSpwx5brcjV4C2nMeoc9OyG60/+Glw0dA3JOSSIU2BQIm7dmtFb7AoMHZhVOddVENMiXQOaLdcfrhLiPEXmpmMywdB04t89/1O/w1cDnyilFU=',
		]);

		try{
			$events = $bot->parseEventRequest($request->getContent(), $signature);
		}
		catch(Exception $e){

		}

		$message_events= [];
		foreach($events as $event){
			if(!($event instanceof \LINE\LINEBot\Event\MessageEvent) && !($event instanceof PostbackEvent)){
				continue;
			}
			$message_events[] = $event;
		}

		$yes_post = new PostbackTempleteActionBuilder("はい", "page={$page}");
		$no_post = new PostbackTempleteActionBuilder("いいえ", "page=-1");
		$confirm = new ConfirmTempleteBuilder("これはテストメッセージです。", [$yes_post, $no_post]);
		$confirm_message = new TempleteMessageBuilder("テストメッセージ", $confirm);

		$message = new MultiMessageBuilder();
		$message->add($confirm_message);
		$res = $bot->replyMessage($event->getReplyToken(), $message);
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
