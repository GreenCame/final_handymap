<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Point;
use DB;
use Auth;

class PointController extends Controller
{

public static function getTypeToPicture($type){
    $TYPE_POINT =  array(
        0 => "bus.png",
        1 => "construct.png",
        2 => "deadend.png",
        3 => "deadly.png",
        4 => "dog.png",
        5 => "down.png",
        6 => "downhill.png",
        7 => "drunk.png",
        8 => "elevator.png",
        9 => "fire.png",
        10 => "help.png",
        11 => "hospital.png",
        12 => "logo.png",
        13 => "mic.png",
        14 => "mic-animate.gif",
        15 => "mic-slash.gif",
        16 => "narrow.png",
        17 => "parking.png",
        18 => "police.png",
        19 => "rock.png",
        20 => "shit.png",
        21 => "slip.png",
        22 => "slippery.png",
        23 => "stair.png",
        24 => "up.png",
        25 => "uphill.png"
    );
    return "/assets/images/markers/".$TYPE_POINT[$type];
}

    public function getContribution($user)
    {
        $id = DB::table('users')
            ->select('id')
            ->where('pseudo', '=', $user)->where("pseudo", "=", $user)
            ->first()->id;

        return DB::table("points")
            ->leftjoin('users', 'points.user_id', '=', 'users.id')
            ->leftjoin('confirmations', 'points.id', '=', 'confirmations.point_id')
            ->select('points.*', 'users.pseudo AS writer',  DB::raw('ifnull(SUM(case confirmations.isConfirm when 1 then 1 else -1 end),0) AS confirmed'))
            ->where("points.user_id", "=", $id)
            ->groupBy('points.id')
            ->orderBy('created_at', 'desc')
            ->get();
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
            ->select('points.*', 'pseudo AS writer',  DB::raw('ifnull(SUM(case confirmations.isConfirm when 1 then 1 else -1 end),0) AS confirmed'))
            ->where("isValidate", "=", 1)
            ->groupBy('points.id')
            ->orderBy('created_at', 'desc')
            ->get();
       for ($i = 0; $i < count($points); $i++) {
           $points[$i]->typePicture = self::getTypeToPicture($points[$i]->type);
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

    public function addPoint()
    {
        Point::create([
            'user_id' => Auth::user()->id,
            'longitude' => $_GET["longitude"],
            'latitude' => $_GET["latitude"],
            'rateValue' => $_GET["rateValue"],
            'description' => $_GET["description"],
            'type' => $_GET["type"]
        ]);
    }

}
