@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <img height="40" class="avatar" style="margin:0px 10px" src="{{URL::asset('assets/images/avatars/'.Auth::user()->avatar)}}">
                            {{Auth::user()->pseudo }} what do you think about HandyMap ?
                        </h4>
                    </div>
                    <form class="form-vertical" role="form" method="POST"
                          action="{{ url('/feedback') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                                <textarea class="form-control" rows="10" name="comment" autofocus>{{ old('comment') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <a href="/profile" class="btn btn-danger ">back</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-success right">
                                    <i class="fa fa-btn fa-pencil"></i> Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection