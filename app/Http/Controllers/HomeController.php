<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Requests;
use Auth;
use App\User;
use Illuminate\Http\Request;

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

    public function feedback()
    {
        return view('user.feedback');
    }

    public function postFeedback()
    {
        if(User::find(Auth::user()->id)->feedbacks()->count()<6) {
            Feedback::create([
                'user_id' => Auth::user()->id,
                'comment' => strip_tags($_POST['comment'])
            ]);
            $feedback = "Thank you so much for your feedback !";
            $data = array(
                "feedbackSuccess" => $feedback
            );
        }
        else{
            $feedback = "You can't send more than 5 feedbacks";
            $data = array(
                "feedbackFail" => $feedback
            );
        }

        return view('user.profile', $data);
    }
}
