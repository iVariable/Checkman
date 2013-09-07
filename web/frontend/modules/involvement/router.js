define(
    [
        'bicycle',

        './views/list'
    ],
    function(
        Bicycle,

        View_List
    ){
        var router = Bicycle.Core.Router.extend({
            routes : {
                "involvement" : "route_involvement"
            },
            route_involvement : function(){
                this.app().layouts.main.content.show( new View_List() );
            }

        });

        return router;
    }
)