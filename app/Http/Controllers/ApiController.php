<?php namespace App\Http\Controllers;

use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($ids)
	{
		//
		$result = DB::connection('disc')->select('select title, disc, rental_year, rental_day, store from disc_data where number=?', [$ids]);

		//echo $result->title;

		$title;
		$disc;
		$rental_year;
		$rental_day;
		$store;


		foreach($result as $data){
			$title = $data->title;
			$disc = $data->disc;
			$rental_year =  $data->rental_year;
			$rental_day = $data->rental_day;
			$store = $data->store;
		}

		$data = [];
		$data['title'] = $title;
		$data['disc'] = $disc;
		$data['rental_year'] = $rental_year;
		$data['rental_day'] = $rental_day;
		$data['store'] = $store;

		return view('detail', $data);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($ids)
	{
		//
		$result = DB::connection('disc')->select('select * from search_adult_disc where number=?', [$ids]);

		//echo $result->title;


		foreach($result as $data){
			$title = $data->title;
			$disc = $data->disc;
			$rental_year =  $data->rental_year;
			$rental_day = $data->rental_day;
			$store = $data->store;
		}

		$data = [];
		$data["disc"] = $disc;
		$data["title"] = $title;
		$data["rental_year"] = $rental_year;
		$data["rental_day"] = $rental_day;
		$data["store"] = $store;

		return view('detail', $data);
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
