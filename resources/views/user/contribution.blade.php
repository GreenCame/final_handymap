@extends('layouts.app')
@section('links')
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('assets/js/vue.js')}}"></script>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{URL::asset('assets/js/user.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    @if($pseudo == Auth::user()->pseudo)
                        <div style="background-color: #D2630F; color: white " class="panel-heading">Your contribution  - Thank you so much !</div>
                    @else
                        <div class="panel-heading">The contribution of {{$pseudo}}</div>
                    @endif
                </div>

                <div id="contribution_content">
                    <div class="panel panel-success"  v-if="points.length!=0">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-lg glyphicon-map-marker"></span>
                            Points (@{{points.length}})
                        </div>

                        <table class="table">
                            <tr>
                                <th>Author point</th>
                                <th>Difficulty</th>
                                <th>longitude</th>
                                <th>Latitude</th>
                                <th>Description</th>
                                <th>Confirmation</th>
                                @if($pseudo == Auth::user()->pseudo)
                                    <th>Change</th>
                                @endif
                            </tr>

                            <tr v-for="point in points"
                                is="validatePoint"
                                :point="point"
                                :class="{'disable': !point.isValidate}"
                                    >
                            </tr>
                        </table>
                    </div>
                    <div v-else>
                        <div style="text-align: center;">
                            Loading...
                        </div>
                    </div>
                </div>

                <template id="validatePoint-template">
                    <td>@{{point.writer}}</td>
                    <td>@{{point.rateValue}}<span style="color: grey">/5</span></td>
                    <td>@{{point.longitude}}</td>
                    <td>@{{point.latitude}}</td>
                    <td>@{{point.description}}</td>
                    <td>
                        <span style="color:forestgreen" v-if="point.confirmed > 5">+@{{point.confirmed}}</span>
                        <span style="color:darkred" v-if="point.confirmed < -5">@{{point.confirmed}}</span>
                        <span v-if="point.confirmed >= -5 && point.confirmed <= 5">@{{point.confirmed}}</span>
                        <span style="color:darkslategrey" v-if="point.confirmed == 0">-</span>
                    </td>
                    @if($pseudo == Auth::user()->pseudo)
                        <td v-if="!point.isValidate">
                            <button class="btn btn-danger btn-sm btn-remove"  v-on:click="removePoint"> <span class="glyphicon glyphicon-remove"></span> remove</button>
                        </td>
                        <td style="color: darkgreen" v-else>
                            <span class="glyphicon glyphicon-ok"></span> confirmed</button>
                        </td>
                    @endif
                </template>
            </div>
        </div>
    </div>
@endsection