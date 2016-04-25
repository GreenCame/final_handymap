<?php

namespace App\Http\Controllers;
use App;
use App\Http\Requests;
use App\Chat;
use App\Report;
use Event;
use App\Item;
use App\Events\ItemCreated;
use Illuminate\Http\Request;
use DateTime;
use Input;
use Pusher;
use Auth;

class ChatController extends Controller
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
        return view('chatroom');
    }

    /**
     * Show the application dashboard.
     *
     * @return void
     */
    public function report()
    {
      $chat_id = Input::get('chat_id');

      $report = new Report();
      $report->reporter_id = Auth::user()->id;
      $report->chat_id = $chat_id;
      $report->created_at =new DateTime;
      $report->updated_at =new DateTime;
      $report->save();

      $reports = Report::where('chat_id',$chat_id);

      $count = count($reports);
      if($count > 5)
      {
        $chat = Chat::find($chat_id);
        $chat->banned = true;
        $chat->save();
        $pusher = $this->getPusher();        
        $pusher->trigger( 'test_channel',
                      'remove_chat', 
                      array('id' =>  $chat_id));
      }

      return response()->json(['count' => $chat_id]);
    }

    /**
     * Show the application dashboard.
     *
     * @return void
     */
    public function push()
    {
        $content = Input::get('content');
        
        $chat = new Chat;
        $chat->sender_id = Auth::user()->id;
        $chat->content =$content;
        $chat->created_at =new DateTime;
        $chat->updated_at =new DateTime;
        $chat->save();
        
        $test = $chat;        
        $sender=  Auth::user()->pseudo;
        
        $new_item = '<li class="media chatItem" data-id="'.$chat->id.'">

                                        <div class="media-body">

                                            <div class="media">
                                                <a class="pull-left" href="#">
                                                    <img height="60" width="60" class="media-object img-circle " src="assets/images/avatars/'.Auth::user()->avatar.'">
                                                </a>
                                                <div class="media-body">
                                                   '.$content.'
                                                    <br>
                                                    Sent by : '.$sender.'
                                                    <button type="button" class="reportBtn" data-id="'.$chat->id.'">Report</button>
                                                    <hr>
                                                </div>
                                            </div>

                                        </div>
                                    </li>';

        $pusher = $this->getPusher();
        $pusher->trigger( 'test_channel',
                      'my_event', 
                      array('message' =>  $new_item));
        
        $input = Input::all();

        return response()->json(['message' => $content]);

    }

    private function getPusher()
    {
        $app_id =  env('PUSHER_APP_ID');
        $app_key = env('PUSHER_KEY');
        $app_secret =  env('PUSHER_SECRET');

        return $pusher = new Pusher( $app_key, $app_secret, $app_id,array(),env('PUSHER_HOST') );     
    }
}
