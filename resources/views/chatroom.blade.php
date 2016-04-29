@extends('layouts.app')

@section('content')

  <div class="container">
<div class="row " style="padding-top:40px;">
    <h3 class="text-center" >WELCOME TO CHATROOM </h3>
    <br /><br />
    <div class="container-fluid">
        <div class="panel panel-info">
            <div class="panel-heading">
                RECENT CHAT HISTORY
            </div>
            <div class="panel-body">
<ul class="media-list" id="contentList" style="max-height:400px;overflow: auto" data-user="{{ Auth::user()->id }}">
         @if (count($chats) > 0)
            @foreach ($chats as $chat)
               {!!$chat!!}
            @endforeach
        @endif
</ul>
            </div>
            <div class="panel-footer">
                <div class="input-group">
                                    <input id="content" type="text" class="form-control" placeholder="Enter Message" />
                                    <span class="input-group-btn">
                                        <button id="sendBtn" class="btn btn-info" type="button">SEND</button>
                                    </span>
                                </div>
            </div>
        </div>
    </div>    
</div>
  </div>
@endsection

@section('scripts')
    <script src="https://js.pusher.com/3.0/pusher.min.js"></script>

    <script>
        var pusher = new Pusher("{{ env('PUSHER_KEY') }}",{
          cluster: 'eu'
        });
    </script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('assets/js/chatroom.js')}}"></script>
@endsection
