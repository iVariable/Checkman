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
                "reports/year" : "route_year"
                ,"reports/deviations" : "route_year"
            },
            route_year : function(){
                this.app().layouts.main.content.show( new View_List() );
            }

        });

        return router;
    }
)