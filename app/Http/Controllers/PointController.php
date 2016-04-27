<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Point;
use DB;
use Auth;
use Input;

class PointController extends Controller
{

    public function getContribution($user)
    {
        $id = DB::table('users')
            ->select('id')
            ->where('pseudo', '=', $user)->where("pseudo", "=", $user)
            ->first()->id;

        $points = DB::table("points")
            ->leftjoin('users', 'points.user_id', '=', 'users.id')
            ->leftjoin('confirmations', 'points.id', '=', 'confirmations.point_id')
            ->leftjoin('types', 'types.id', '=', 'points.type_id')
            ->select('points.*', 'users.pseudo AS writer', 'types.picture AS typePicture',  DB::raw('ifnull(SUM(case confirmations.isConfirm when 1 then 1 else -1 end),0) AS confirmed'))
            ->where("points.user_id", "=", $id)
            ->groupBy('points.id')
            ->orderBy('created_at', 'desc')
            ->get();

        for ($i = 0; $i < count($points); $i++) {
            $points[$i]->typePicture = "/assets/images/markers/".$points[$i]->typePicture;
        }
        return $points;
    }

    public function showContribution($user)
    {
        $data =array(
            "pseudo" => $user
        );

        return view('user.contribution', $data);
    }

    public function getPoints()
    {
        $points = DB::table("points")
            ->leftjoin('users', 'points.user_id', '=', 'users.id')
            ->leftjoin('confirmations', 'points.id', '=', 'confirmations.point_id')
            ->leftjoin('types', 'types.id', '=', 'points.type_id')
            ->select('points.*', 'pseudo AS writer', 'types.picture AS typePicture',  DB::raw('ifnull(SUM(case confirmations.isConfirm when 1 then 1 else -1 end),0) AS confirmed'))
            ->where("isValidate", "=", 1)
            ->groupBy('points.id')
            ->orderBy('created_at', 'desc')
            ->get();
        for ($i = 0; $i < count($points); $i++) {
            $points[$i]->typePicture = "/assets/images/markers/".$points[$i]->typePicture;
        }
        return $points;
    }

    public function deletePoint($id)
    {
        if(Auth::user()->isAdmin){
            Point::find($id)->delete();
        }
        else{
            $UserPoint = DB::table('points')
                ->select('user_id', 'isValidate')
                ->where('id', '=', $id)
                ->first();
            if(Auth::user()->id==$UserPoint->user_id && !$UserPoint->isValidate)
            {
                Point::find($id)->delete();
            }
        }
    }

    public function addPoints()
    {
        $point = new Point();
        $point->user_id = Auth::user()->id;
        $point->longitude = Input::get("longitude");
        $point->latitude = Input::get("latitude");
        $point->rateValue = 0;
        $point->description = Input::get("description");
        $point->type_id = $_POST["type"];
        $point->save();
    }

}
