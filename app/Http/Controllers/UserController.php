<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Redirect;
use File;
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





}
