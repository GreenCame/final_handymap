<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use App\Feedback;
use App\Point;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSettingsUser($id)
    {
        $data=array(
            //
        );
        return view('user.settings', $data);
    }
    public function getConsole()
    {
        return view('admin.console');
    }
    public function getUsers()
    {
        return DB::table("users")
            ->leftjoin('feedbacks', 'users.id', '=', 'feedbacks.user_id')
            ->leftjoin('points', 'users.id', '=', 'points.user_id')
            ->select('users.id', 'email', 'firstname', 'lastname', 'pseudo', 'users.description', 'isVoice', 'isColor', 'isBlocked', 'users.created_at', DB::raw('ifnull(count(feedbacks.user_id),0) AS feedbacks'), DB::raw('ifnull(count(points.user_id),0) AS points'))
            ->where("isAdmin", "=", 0)
            ->groupBy('users.id')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function putUser($id)
    {
        $isBlocked=false;
        if(isset($_GET["isBlocked"])) {
            if ($_GET["isBlocked"]=="true"){
                $isBlocked=true;
            }
            else{
                $isBlocked=false;
            }
        }
        //echo $isBlocked? "true": "none";
        User::where('id','=',$id)
            ->update([
                'firstname' => $_GET["firstname"],
                'lastname' => $_GET["lastname"],
                'pseudo' => $_GET["pseudo"],
                'description' => $_GET["description"],
                'isVoice' => $_GET["isVoice"],
                'isColor' => $_GET["isColor"],
                'isBlocked' => $isBlocked,
            ]);
        echo "The user was updated";
    }
    public function deleteUser($id)
    {
        User::find($id)->feedbacksRemove();
        User::find($id)->pointsRemove();
        User::find($id)->delete();
        echo "The user with "+id+ "was delete successfully";
    }
    public function getFeedbacks()
    {
        return DB::table("feedbacks")->join('users', 'users.id', '=', 'feedbacks.user_id')->select('feedbacks.id', 'pseudo AS writer', 'comment', 'feedbacks.created_at')->orderBy('created_at', 'desc')->get();
    }
    public function putFeedback($id)
    {
        Feedback::where('id','=',$id)
            ->update([
                'comment' => $_GET["comment"]
            ]);
    }
    public function deleteFeedback($id)
    {
        Feedback::find($id)->delete();
        echo "Feedback "+$id+" removed";
    }
    public function getWaitingPoints()
    {
        return DB::table("points")
            ->leftjoin('users', 'points.user_id', '=', 'users.id')
            ->leftjoin('confirmations', 'points.id', '=', 'confirmations.point_id')
            ->select('points.*', 'pseudo AS writer',  DB::raw('ifnull(SUM(case confirmations.isConfirm when 1 then 1 else -1 end),0) AS confirmed'))
            ->where("isValidate", "=", 0)
            ->groupBy('points.id')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function putPoint($id)
    {
        Point::find($id)->update(['isValidate' => true]);
    }

}
