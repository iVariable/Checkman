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
                "admin/occupations" : "route_list"
            },
            route_list : function(){
                this.app().layouts.main.content.show( new View_List() );
            }

        });

        return router;
    }
)