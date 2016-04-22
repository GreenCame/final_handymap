<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Redirect;
use File;
use App\Point;
use DB;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
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
    public function getSettings()
    {
        return view('user.settings');
    }


    public function postSettings(UpdateUserRequest $request)
    {
        if ($request->isVoice) {
            $isVoice = 1;
        } else {
            $isVoice = 0;
        }

        if ($request->isColor) {
            $isColor = 1;
        } else {
            $isColor = 0;
        }

        if (!$_FILES['avatar']['name']==""&&$_FILES['avatar']['error']==0) {
            if ($request->file('avatar')->isValid()) {
                $path = public_path().'\assets\images\avatars\\';

                if (File::exists($path.Auth::user()->avatar))
                {
                    File::delete($path.Auth::user()->avatar);
                }
                $name="Avatar_".md5(Auth::user()->id).'_'.date('YmdHis').'.'.$request->file('avatar')->getClientOriginalExtension();
                $request->file('avatar')->move($path, $name);
                User::where('id', '=', Auth::user()->id)->update(['avatar' => $name]);
            }
        }

        User::where('id', '=', Auth::user()->id)->update(array('firstname' => $request->firstname, 'lastname' =>$request->lastname, 'isVoice' => $isVoice, 'isColor' => $isColor, 'description' => $request->description));
        return redirect("/profile");
    }

    public function getProfile()
    {
        return view('user.profile');
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
        return DB::table("points")
            ->leftjoin('users', 'points.user_id', '=', 'users.id')
            ->leftjoin('confirmations', 'points.id', '=', 'confirmations.point_id')
            ->select('points.*', 'pseudo AS writer',  DB::raw('ifnull(SUM(case confirmations.isConfirm when 1 then 1 else -1 end),0) AS confirmed'))
            ->where("isValidate", "=", 1)
            ->groupBy('points.id')
            ->orderBy('created_at', 'desc')
            ->get();
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



}
