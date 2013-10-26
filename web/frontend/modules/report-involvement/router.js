define(
    [
        'bicycle'
        ,'./views/byProject'
        ,'./views/byEmployee'
    ],
    function(
        Bicycle,
        View_Project,
        View_Employee
    ){
        var router = Bicycle.Core.Router.extend({
            routes : {
                "involvement/by-project" : "route_involvement_by_project"
                ,"involvement/by-employee" : "route_involvement_by_employee"
            },
            route_involvement_by_project : function(){
                this.app().layouts.main.content.show( new View_Project() );
            },
            route_involvement_by_employee : function(){
                this.app().layouts.main.content.show( new View_Employee() );
            }

        });

        return router;
    }
)