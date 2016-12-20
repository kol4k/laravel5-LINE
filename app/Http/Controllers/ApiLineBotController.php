<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiLineBotController extends Controller {


	public function postIndex()
	{

		$accessToken = 'kBNUMY+e1dUqU0EryiH2ozXsPnFC8+b4ETBsLrcQyI2fr2OB2xHIl4HLHg0Fml4GXqfBhyARJ5QrBVkzGD9CUr6q1kVgd8xqMWbm/vJ15cUs7ZVXD/Tj58SYEu5VD/oqrkkTtbuqrMhqh5eWJKEp1QdB04t89/1O/w1cDnyilFU=';

		//ユーザーからのメッセージ取得
		$json_string = file_get_contents('php://input');
		$jsonObj = json_decode($json_string);

		$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
		//メッセージ取得
		$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
		//ReplyToken取得
		$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

		//メッセージ以外のときは何も返さず終了
		if($type != "text"){
			exit;
		}

		$fullpath = 'python /var/python/test.py 1234';

		exec($fullpath, $outparameter);
		/*
		ob_start();
		var_dump($outparameter[0]);
		$output = ob_get_contents();
		ob_end_clean();
		*/
     $output = $outparameter[0];

		//返信データ作成
		if ($text == 'はい') {
			$response_format_text = [
				"type" => "text",
				"text" => $output
			];
		}
		else if($text == 'はいね') {
		  $response_format_text = [
		    "type" => "template",
		    "altText" => "こちらの〇〇はいかがですか？",
		    "template" => [
		      "type" => "buttons",
		      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
		      "title" => "○○レストラン",
		      "text" => "お探しのレストランはこれですね",
		      "actions" => [
		          [
		            "type" => "postback",
		            "label" => "予約する",
		            "data" => "action=buy&itemid=123"
		          ],
		          [
		            "type" => "postback",
		            "label" => "電話する",
		            "data" => "action=pcall&itemid=123"
		          ],
		          [
		            "type" => "uri",
		            "label" => "詳しく見る",
		            "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
		          ],
		          [
		            "type" => "message",
		            "label" => "違うやつ",
		            "text" => "違うやつお願い"
		          ]
		      ]
		    ]
		  ];
		} else if ($text == 'いいえ') {
		  exit;
		} else if ($text == '違うやつお願い') {
		  $response_format_text = [
		    "type" => "template",
		    "altText" => "候補を３つご案内しています。",
		    "template" => [
		      "type" => "carousel",
		      "columns" => [
		          [
		            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
		            "title" => "●●レストラン",
		            "text" => "こちらにしますか？",
		            "actions" => [
		              [
		                  "type" => "postback",
		                  "label" => "予約する",
		                  "data" => "action=rsv&itemid=111"
		              ],
		              [
		                  "type" => "postback",
		                  "label" => "電話する",
		                  "data" => "action=pcall&itemid=111"
		              ],
		              [
		                  "type" => "uri",
		                  "label" => "詳しく見る（ブラウザ起動）",
		                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
		              ]
		            ]
		          ],
		          [
		            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
		            "title" => "▲▲レストラン",
		            "text" => "それともこちら？（２つ目）",
		            "actions" => [
		              [
		                  "type" => "postback",
		                  "label" => "予約する",
		                  "data" => "action=rsv&itemid=222"
		              ],
		              [
		                  "type" => "postback",
		                  "label" => "電話する",
		                  "data" => "action=pcall&itemid=222"
		              ],
		              [
		                  "type" => "uri",
		                  "label" => "詳しく見る（ブラウザ起動）",
		                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
		              ]
		            ]
		          ],
		          [
		            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
		            "title" => "■■レストラン",
		            "text" => "はたまたこちら？（３つ目）",
		            "actions" => [
		              [
		                  "type" => "postback",
		                  "label" => "予約する",
		                  "data" => "action=rsv&itemid=333"
		              ],
		              [
		                  "type" => "postback",
		                  "label" => "電話する",
		                  "data" => "action=pcall&itemid=333"
		              ],
		              [
		                  "type" => "uri",
		                  "label" => "詳しく見る（ブラウザ起動）",
		                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
		              ]
		            ]
		          ]
		      ]
		    ]
		  ];
		} else {
		  $response_format_text = [
		    "type" => "template",
		    "altText" => "こんにちは 何かご用ですか？（はい／いいえ）",
		    "template" => [
		        "type" => "confirm",
		        "text" => "こんにちは 何かご用ですか？",
		        "actions" => [
		            [
		              "type" => "message",
		              "label" => "はい",
		              "text" => "はい"
		            ],
		            [
		              "type" => "message",
		              "label" => "いいえ",
		              "text" => "いいえ"
		            ]
		        ]
		    ]
		  ];
		}

		$post_data = [
			"replyToken" => $replyToken,
			"messages" => [$response_format_text]
			];

		$ch = curl_init("https://api.line.me/v2/bot/message/reply");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json; charser=UTF-8',
		    'Authorization: Bearer ' . $accessToken
		    ));
		$result = curl_exec($ch);
		curl_close($ch);

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
