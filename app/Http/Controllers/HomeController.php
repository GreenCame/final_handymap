<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Input;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('map');
    }

    public function add_point()
    {
       
        $creater= Auth::user()->pseudo;
        $lng = Input::get('lng');
        $lat = Input::get('lat');
        $lat = Input::get('desc');
        $point = new Point();
        $point->longitude = $lng;
        $point->latitude = $lat;
        $point->description = $desc;

        return response()->json(['creater_name' => $creater]);

    }
}
