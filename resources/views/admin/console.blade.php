@extends('layouts.app')
@section('links')
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('assets/js/vue.js')}}"></script>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{URL::asset('assets/js/admin.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">What you need to do ?</div>

                    <div class="list-group">
                        <a href="#" id="users" class="list-group-item"> <span class="glyphicon glyphicon-chevron-right"
                                                                   aria-hidden="true"></span> <b>Users</b></a>
                        <a href="#" id="feedbacks" class="list-group-item"> <span class="glyphicon glyphicon-chevron-right"
                                                                   aria-hidden="true"></span> <b>Feedbacks</b></a>
                        <a href="#" id="pointsConfirm" class="list-group-item"> <span class="glyphicon glyphicon-chevron-right"
                                                                   aria-hidden="true"></span> New
                            <b>points</b></a>
                        <a href="#" id="pointsValidate" class="list-group-item"> <span class="glyphicon glyphicon-chevron-right"
                                                                               aria-hidden="true"></span> Show confirmed
                            <b>points</b></a>
                    </div>
                </div>

                <!--<div id="app">
                    <h1>@{{ points.length }}</h1>
                      @{{ pointDescription }}
                    <input type="text" v-model="pointDescription" @keyup.enter="createPoint">
                    <p>
                        <a v-bind:href="url">clic</a>
                    </p>
                    <h1 v-if="points.length">Validate</h1>
                    <ul>
                        <li v-for="point in points">
                            @{{ point.description }}
                            <input type="checkbox" v-model="point.isValidate">
                            <button @click="removePoint(point)">Remove</button>
                        </li>
                    </ul>
                    <h2 v-if="points.length">not validate</h2>
                    <ul>
                        <li v-repeat="point: points | filterBy false in points">
                            @{{ point.description }}
                            <input type="checkbox" v-model="point.isValidate">
                            <button v-on:click="removePoint(point)">Remove</button>
                        </li>
                    </ul>
                    <pre>@{{ $data | json }}</pre>
                </div>-->

                <div id="users_content" style="display: none;">
                    <div class="panel panel-primary" v-if="users.length!=0">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-lg glyphicon-user"></span>
                            Users ( <b>@{{totalActiveUser}}</b> actives / @{{users.length}} )
                        </div>

                            <table class="table">
                                <tr>
                                    <th>Pseudo</th>
                                    <th>Name</th>
                                    <th>Firstname</th>
                                    <th>Mail</th>
                                    <th>feedback</th>
                                    <th>points added</th>
                                    <th>Change</th>
                                </tr>

                                <tr v-for="user in users"
                                    is="user"
                                    :user="user"
                                    :class="{'user_ban': user.isBlocked}">
                                </tr>

                            </table>
                         </div>
                    <div v-else>
                        <div style="text-align: center;">
                            Loading...
                        </div>
                    </div>

                </div>

                <div id="feedbacks_content" style="display: none;">
                    <div class="panel panel-primary"  v-if="feedbacks.length!=0">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-lg glyphicon-inbox"></span>
                             Feedbacks (@{{feedbacks.length}})
                        </div>

                        <table class="table">
                            <tr>
                                <th>Writer</th>
                                <th>Feedback</th>
                                <th>Answer</th>
                            </tr>
                            <tr v-for="feedback in feedbacks"
                                is="feedback"
                                :feedback="feedback"
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

                <div id="pointsConfirm_content" style="display: none;">
                    <div class="panel panel-info"  v-if="points.length!=0">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-lg glyphicon-map-marker"></span>
                             Points to confirm (@{{points.length}})
                        </div>

                            <table class="table">
                                <tr>
                                    <th>Author point</th>
                                    <th>Difficulty</th>
                                    <th>longitude</th>
                                    <th>Latitude</th>
                                    <th>Description</th>
                                    <th>Confirmation</th>
                                    <th>Change</th>
                                </tr>

                                <tr v-for="point in points"
                                    is="waitingPoint"
                                    :point="point"
                                    :class="{'success': point.confirmed > 5 , 'danger': point.confirmed < -5}"
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

                <div id="validatePoints_content" style="display: none;">
                    <div class="panel panel-success"  v-if="points.length!=0">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-lg glyphicon-map-marker"></span>
                            Points to confirm (@{{points.length}})
                        </div>

                        <table class="table">
                            <tr>
                                <th>Author point</th>
                                <th>Difficulty</th>
                                <th>longitude</th>
                                <th>Latitude</th>
                                <th>Description</th>
                                <th>Confirmation</th>
                                <th>Change</th>
                            </tr>

                            <tr v-for="point in points"
                                is="validatePoint"
                                :point="point"
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

                <template id="user-template">
                    <td v-if="isBan">@{{user.pseudo}}<b style="color:darkred"><span style="color:darkred" class="glyphicon glyphicon-ban-circle"></span> is ban</b></td>
                    <td v-else>@{{user.pseudo}}</td>
                    <td>
                        <span v-on:click="clicked"
                              v-show="!isEditMode"
                                >
                            @{{user.lastname}}
                        </span>
                        <span v-show="isEditMode">
                            <input type="text"
                                   size="7"
                                   v-model="user.lastname"
                                   v-on:keyup.enter="clicked"
                                    >
                        </span>
                    </td>
                    <td>
                        <span v-on:click="clicked"
                              v-show="!isEditMode"
                                >
                            @{{user.firstname}}
                        </span>
                        <span v-show="isEditMode">
                            <input type="text"
                                   size="7"
                                   v-model="user.firstname"
                                   v-on:keyup.enter="clicked"
                                    >
                        </span>
                    </td>
                    <td>@{{user.email}}</td>
                    <td>
                        <span v-if="user.feedbacks==0">-</span>
                        <span v-if="user.feedbacks!=0">@{{user.feedbacks}}</span>
                    </td>
                    <td>
                        <span v-if="user.points==0">-</span>
                        <span v-if="user.points!=0">@{{user.points}}</span>
                    </td>
                    <td>
                        <!--
                             Bouton Save
                         -->
                        <button class="btn btn-info btn-sm "
                                v-on:click="clicked"
                                >
                            <span class="glyphicon glyphicon-floppy-disk" v-if="isEditMode"></span>
                            <span class="glyphicon glyphicon-pencil" v-if="!isEditMode"></span>
                        </button>

                        <!--
                            Bouton Ban
                        -->
                        <button class="btn btn-success btn-sm"
                                v-on:click="banUser"
                                v-if="isBan"
                                >
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                        <button class="btn btn-warning btn-sm"
                                v-on:click="banUser"
                                v-else
                                >
                            <span class="glyphicon glyphicon-ban-circle"></span>
                        </button>

                        <!--
                            Bouton Remove
                        -->
                        <button class="btn btn-danger btn-sm"
                                v-on:click="removeUser"
                                >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                </template>

                <template id="feedback-template">
                    <td>@{{feedback.writer}}</td>
                    <td>@{{feedback.comment}}</td>
                    <td>
                        <button class="btn btn-success btn-sm ">
                            <span class="glyphicon glyphicon-pencil"></span>
                            answer
                        </button><br />

                        <button class="btn btn-danger btn-sm pull-right"
                                v-on:click="removeFeedback"
                                >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                </template>

                <template id="pointConfirm-template">
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
                    <td><button class="btn btn-info btn-sm" v-on:click="/map/@{{ point.latitude }}/@{{ point.longitude }}" >  <span class="glyphicon glyphicon-eye-open"></span>   show it </button><br />
                        <button class="btn btn-success btn-sm" v-on:click="confirmPoint">  <span class="glyphicon glyphicon-ok"></span> validate  </button><br />
                        <button class="btn btn-danger btn-sm btn-remove"  v-on:click="removePoint"> <span class="glyphicon glyphicon-remove"></span> remove</button>
                    </td>
                </template>

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
                    <td><button class="btn btn-info btn-sm" >  <span class="glyphicon glyphicon-eye-open"></span>   show it </button><br />
                        <button class="btn btn-warning btn-sm" onClick="unValidatePoint">  <span class="glyphicon glyphicon-erase"></span> Unvalidate</button><br />
                        <button class="btn btn-danger btn-sm btn-remove"  onClick="deletePoint"> <span class="glyphicon glyphicon-remove"></span> remove</button>
                    </td>
                </template>
            </div>
    </div>
    </div>
@endsection