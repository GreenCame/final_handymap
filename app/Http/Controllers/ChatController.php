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
use App\User;
use DB;

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
        $current_user_id=  Auth::user()->id;

        $reported_chats = DB::table('report')->select('chat_id')->where('reporter_id', '=', $current_user_id)->get();

        $reported_id = array();
        foreach($reported_chats as $report)
        {
           $reported_id[] = $report->chat_id;
        }

        $chats = DB::table('chat')
        ->whereNotIn('id', $reported_id)
        ->orderBy('id', 'desc')
        ->take(5)->get();
        $items = [];
        while(count($chats) > 0)
        {
            $chat = array_shift($chats);
            $sender = User::find( $chat->sender_id);

            $item = '<li class="media chatItem" data-id="'.$chat->id.'">

                                        <div class="media-body">

                                            <div class="media">
                                                <a class="pull-left" href="#">
                                                    <img height="40" width="40" class="media-object img-circle " src="assets/images/avatars/'.Auth::user()->avatar.'">
                                                </a>
                                                <div class="bubble me">
                                                   '.$chat->content.'
                                                    <br>
                                                    <div style="color:coral;font-weight: bold;">
													Sent by : '.$sender->pseudo;
                                          if($chat->sender_id !== $current_user_id){
                  $item .='<br><button type="button" class="reportBtn" data-id="'.$chat->id.'">Report</button>';
                         }
                          $item .=    '
						  </div>
                                                </div>
                                            </div>

                                        </div>
                                    </li>';
           $items[] = $item;
        }
		
        return view('map')->with('chats', $items);
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
                                                    <img height="40" width="40" class="media-object img-circle " src="assets/images/avatars/'.Auth::user()->avatar.'">
                                                </a>
                                                <div class="bubble me">
                                                   '.$content.'
                                                    <br>
													<div style="color:coral;font-weight: bold;">
                                                    Sent by : '.$sender.'
													</div>
                                                    <button type="button" class="reportBtn" data-id="'.$chat->id.'">Report</button>
                                                    
                                                </div>
                                            </div>

                                        </div>
                                    </li>';

        $pusher = $this->getPusher();
        $pusher->trigger( 'test_channel',
                      'my_event', 
                      array('message' =>  $new_item,'sender_id' => Auth::user()->id));
        
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
