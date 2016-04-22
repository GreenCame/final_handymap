@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Settings Account</div>
                    <div class="panel-body">
                        <form class="form-vertical" role="form" method="POST" enctype="multipart/form-data"
                              action="{{ url('/settings') }}">
                            {!! csrf_field() !!}
                            <input value="put" type="hidden" name="_method">

                            <div class="row{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label class="col-md-3 text-right">FirstName</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="firstname" autofocus
                                           @if(old('firstname'))
                                           value="{{ old('firstname') }}">
                                    @else
                                        value="{{ Auth::user()->firstname }}">
                                    @endif

                                    @if ($errors->has('firstname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label class="col-md-3 text-right">LastName</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lastname"
                                           @if(old('lastname'))
                                           value="{{ old('lastname') }}">
                                    @else
                                        value="{{ Auth::user()->lastname }}">
                                    @endif
                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group" style="margin-left: 80px;">
                                <label for="image">avatar</label>

                                <div class="row">
                                    <div class="col-md-4">
                                        <img height="150"
                                             src="{{URL::asset('assets/images/avatars/'.Auth::user()->avatar)}}">
                                    </div>
                                    <div class="col-md-8" style="margin-top:60px">
                                        <input accept="image/*" type="file" name="avatar">
                                        @if ($errors->has('avatar'))
                                                <span class=" help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Description">Description</label>
                                @if(Auth::user()->description!=null)
                                    <textarea class="form-control" rows="3" name="description">
                                        @if(old('description'))
                                            {{ old('description') }}
                                        @else
                                            {{Auth::user()->description}}
                                        @endif
                                    </textarea>
                                @else
                                    <textarea class="form-control" rows="3" name="description"
                                              placeholder="Something interesting...">{{ old('description') }}</textarea>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-10">
                                    <div class="col-md-10 ">
                                        @if(Auth::user()->isVoice==1)
                                            <input type="checkbox" name="isVoice" checked>
                                        @else
                                            <input type="checkbox" name="isVoice">
                                        @endif
                                        Active <b>voice</b>

                                        <p class="text-muted">Active the voice control functionality.</p>
                                    </div>

                                </div>
                                <div class=" col-md-10">
                                    <div class="col-md-10 ">
                                        @if(Auth::user()->isColor==1)
                                            <input type="checkbox" name="isColor" checked>
                                        @else
                                            <input type="checkbox" name="isColor">
                                        @endif
                                        Active <b>color</b>

                                        <p class="text-muted">Active the black and white design.</p>
                                    </div>

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <a href="/profile" class="btn btn-danger ">back</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-success right">
                                        <i class="fa fa-btn fa-pencil"></i> Save
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