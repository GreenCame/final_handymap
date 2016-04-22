@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(isset($feedbackSuccess))
                        <div class="panel-heading" style="background-color: darkgreen !important; color: white;">
                            <h3>
                                <div class="glyphicon glyphicon-ok"></div>
                                {{ $feedbackSuccess }}
                            </h3>
                        </div>
                    @endif
                    @if(isset($feedbackFail))
                        <div class="panel-heading" style="background-color: darkred !important; color: white;">
                            <h3>
                                <div class="glyphicon glyphicon-not-ok"></div>
                                {{ $feedbackFail }}
                            </h3>
                        </div>
                    @endif
                    <div class="panel-heading">
                        <h4>
                            <div class="glyphicon glyphicon-menu-down small"></div>
                            <img height="40" class="avatar" style="margin:0px 10px" src="{{URL::asset('assets/images/avatars/'.Auth::user()->avatar)}}">
                            {{Auth::user()->pseudo }}
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 text-center small">
                                Personnal
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 text-right">
                                <label>Lastname :</label>
                            </div>
                            <div class="col-sm-10">
                                @if(Auth::user()->lastname==null)
                                    <div class="text-capitalize"> - </div>
                                @else
                                    <div class="text-capitalize">{{ Auth::user()->lastname }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 text-right">
                                <label>Firstname :</label>
                            </div>
                            <div class="col-sm-10">
                                @if(Auth::user()->firstname==null)
                                    <div class="text-capitalize"> -</div>
                                @else
                                    <div class="text-capitalize">{{ Auth::user()->firstname }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center small">
                            Options
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 text-right"><label>Email :</label></div>
                        <div class="col-sm-10">{{Auth::user()->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 text-right"><label>Description :</label></div>
                        @if(Auth::user()->description==null)
                            <div class="col-sm-10"> -</div>
                        @else
                            <div class="col-sm-10">{{ Auth::user()->description }}</div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-2 text-right"><label>Voice :</label></div>
                        @if((Auth::user()->isVoice)==1)
                            <div class="col-sm-10"><i class="glyphicon glyphicon-ok" style="color:green"></i> (Activate)</div>
                        @else
                            <div class="col-sm-10"><i class="fa fa-btn fa-remove" style="color:red"></i> (Off)</div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-2 text-right"><label>Color :</label></div>
                        @if((Auth::user()->isColor)==1)
                            <div class="col-sm-10"><i class="glyphicon glyphicon-ok"  style="color:green"></i> (Activate)</div>
                        @else
                            <div class="col-sm-10"><i class="fa fa-btn fa-remove" style="color:red"></i> (Off)</div>
                        @endif
                    </div>
                    <div class="row" style="margin: 30px 0px">
                        <div class="col-md-12 text-center">
                            <a href="/settings" class=" col-md-10 col-md-offset-1 btn btn-info"><h5>update</h5></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection