<?php namespace App\Http\Middleware;

use Closure;

class AppBeforeFilter {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		//HTTPのリクエストをHTTPSのリクエストに置き換える
		/*
		if (!$request->secure() && env('APP_ENV') === 'local') {
			return redirect()->secure($request->getRequestUri());
    }
		*/

		//HTTPSでの通信でなければJSON形式でrequest errorを送信する
		if (!$request->secure() && env('APP_ENV') === 'local') {

			//HTTPS通信でなければJSON形式でエラーをthrowする
			return response()->json(['status' => 'Bad request.', 'message' => 'HTTP secure communication required.']);

		}

		return $next($request);
	}

}
