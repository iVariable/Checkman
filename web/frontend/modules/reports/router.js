define(
    [
        'bicycle',

        './views/year'
    ],
    function(
        Bicycle,

        View_Year
    ){
        var router = Bicycle.Core.Router.extend({
            routes : {
                "reports/year" : "route_year"
                ,"reports/deviations" : "route_year"
            },
            route_year : function(){
                this.app().layouts.main.content.show( new View_Year() );
            }

        });

        return router;
    }
)