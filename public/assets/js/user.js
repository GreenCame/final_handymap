new Vue({
    el: '#contribution_content',
    data: function () {
        return {points: []}
    },
    created: function () {
        var pathArray = window.location.pathname.split( '/' );
        var user;
        user = pathArray[2];
        console.log(user);
        $.getJSON("/api/points/get/"+user, function (data) {
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
                    console.log("api/points/delete/" + this.point.id);
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
