define(
    [
        'bicycle',

        './views/dashboard'
    ],
    function(
        Bicycle,

        View_Dashboard
    ){
        var router = Bicycle.Core.Router.extend({
            routes : {
                "" : "route_dashboard"
            },
            route_dashboard : function(){
                this.app().layouts.main.content.show( new View_Dashboard() );
            }

        });

        return router;
    }
)