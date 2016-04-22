function getUsers() {
    new Vue({
        el: '#users_content',
        data: function () {
            return {users: []}
        },
        created: function () {
            $.getJSON("/api/users/get", function (data) {
                this.users = data;
            }.bind(this));
        },

        computed: {
            totalActiveUser: function () {
                return this.users.filter(function (user) {
                    return !user.isBlocked;
                }).length;
            }
        },

        events: {
            'saveUser': function (user) {

            },
            'removeUser': function (user) {
                $.get("api/users/delete/"+user.id, function(data) {});
                this.users.$remove(user);
            }
        },

        components: {
            user: {
                template: '#user-template',
                props: ["user"],
                replace: false,
                data: function(){
                    return {
                        isEditMode:false
                        }
                },
                methods: {
                    banUser: function () {
                        if (this.user.isBlocked) {
                            this.user.isBlocked = false;
                        }
                        else {
                            this.user.isBlocked = true;
                        }
                        this.saveUser();
                    },
                    saveUser: function () {
                        $.ajax({
                            url: "api/users/put/"+this.user.id,
                            type: "GET",
                            data: this.user,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                        this.$dispatch("saveUser", this.user);
                    },
                    removeUser: function () {
                        this.$dispatch("removeUser", this.user);
                    },
                    clicked: function(){
                        if(this.isEditMode){
                            this.isEditMode=false;
                            this.saveUser();
                        }
                        else {
                            this.isEditMode = true;
                        }
                    }
                },
                computed: {
                    isBan: function () {
                        return this.user.isBlocked;
                    }
                }
            }
        }
    });
}

function getFeedbacks() {
    new Vue({
        el: '#feedbacks_content',
        data: function () {
            return {feedbacks: []}
        },
        created: function () {
            $.getJSON("/api/feedbacks/get", function (data) {
                this.feedbacks = data;
            }.bind(this));
        },
        computed: {
        },
        events: {
            'removeFeedback':function (feedback) {
                this.feedbacks.$remove(feedback);
            }
        },
        components: {
            feedback: {
                template: '#feedback-template',
                props: ["feedback"],
                replace: false,
                methods: {
                    removeFeedback: function() {
                        $.ajax({
                            url: "api/feedbacks/delete/" + this.feedback.id,
                            type: "GET",
                            success: function (data) {
                                console.log(data);
                            }
                        });
                        this.$dispatch("removeFeedback", this.feedback);
                    },
                    putFeedback: function(){
                        $.ajax({
                            url: "api/feedbacks/put/"+this.feedback.id,
                            type: "GET",
                            data: this.feedback,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    }
                },
                computed: {
                }
            }
        }
    });
}
function getPointsToConfirm() {
    new Vue({
        el: '#pointsConfirm_content',
        data: function () {
            return {points: []}
        },
        created: function () {
            $.getJSON("/api/waiting_points/get", function (data) {
                this.points = data;
            }.bind(this));
        },
        computed: {
        },
        events: {
            'removePoint':function (point) {
                this.points.$remove(point);
            }
        },
        components: {
            waitingPoint: {
                template: '#pointConfirm-template',
                props: ["point"],
                replace: false,
                methods: {
                    removePoint: function() {
                        $.ajax({
                            url: "api/points/delete/" + this.point.id,
                            type: "GET",
                            success: function (data) {
                                console.log(data);
                            }
                        });
                        this.$dispatch("removePoint", this.point);
                    },
                    putPoint: function(){
                        $.ajax({
                            url: "api/points/put/"+this.point.id,
                            type: "GET",
                            data: this.point,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    },
                    confirmPoint: function(){
                        this.putPoint();
                        this.$dispatch("removePoint", this.point);
                    }
                },
                computed: {
                }
            }
        }
    });
}
function getPoints() {
    new Vue({
        el: '#validatePoints_content',
        data: function () {
            return {points: []}
        },
        created: function () {
            $.getJSON("/api/points/get", function (data) {
                this.points = data;
            }.bind(this));
        },
        computed: {
        },
        events: {
            'removePoint':function (point) {
                this.points.$remove(point);
            }
        },
        components: {
            validatePoint: {
                template: '#validatePoint-template',
                props: ["point"],
                replace: false,
                methods: {
                    removePoint: function() {
                        $.ajax({
                            url: "api/points/delete/" + this.point.id,
                            type: "GET",
                            success: function (data) {
                                console.log(data);
                            }
                        });
                        this.$dispatch("removePoint", this.point);
                    },
                    putPoint: function(){
                        $.ajax({
                            url: "api/points/put/"+this.point.id,
                            type: "GET",
                            data: this.point,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    },
                    confirmPoint: function(){
                        this.putPoint();
                        this.$dispatch("removePoint", this.point);
                    }
                },
                computed: {
                }
            }
        }
    });
}
function removeButton(){
    //remove all
    $(".list-group-item").removeClass("active");
    $(".list-group-item").find(".glyphicon").removeClass("rotateDownIn");
    $(".list-group-item").find(".glyphicon").addClass("rotateDownOut");
    $("#users_content").hide();
    $("#feedbacks_content").hide();
    $("#validatePoints_content").hide();
    $("#pointsConfirm_content").hide();
}

function showButton(id){
    $(id).addClass("active");
    $(id).find(".glyphicon").removeClass("rotateDownOut");
    $(id).find(".glyphicon").addClass("rotateDownIn");
}

$("#users").click(function () {
    var content = "#users_content";
    if($(content).is(":visible"))    {
        removeButton();
        $(content).hide();
    }
    //$('#action').html("");
    else if($(content)){
        removeButton();
        showButton(this);
        $(content).show();
    }
    getUsers();
});
$("#feedbacks").click(function () {
    var content = "#feedbacks_content";
    if($(content).is(":visible"))    {
        removeButton();
    }
    //$('#action').html("");
    else if($(content)){
        removeButton();
        showButton(this);
        $(content).show();
    }
    getFeedbacks();
});
$("#pointsConfirm").click(function () {
    var content = "#pointsConfirm_content";
    if($(content).is(":visible"))    {
        removeButton();
    }
    //$('#action').html("");
    else if($(content)){
        removeButton();
        showButton(this);
        $(content).show();
    }
    getPointsToConfirm();
});
$("#pointsValidate").click(function () {
    var content = "#validatePoints_content";
    if($(content).is(":visible"))    {
        removeButton();
    }
    //$('#action').html("");
    else if($(content)){
        removeButton();
        showButton(this);
        $(content).show();
    }
    getPoints();
});
