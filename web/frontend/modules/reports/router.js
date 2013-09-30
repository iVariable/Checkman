define(
    [
        'bicycle',

        './views/year'
        ,'./views/list'
        ,'./views/projects'
    ],
    function(
        Bicycle,

        View_Year
        ,View_List
        ,View_Projects

    ){
        var router = Bicycle.Core.Router.extend({
            routes : {
                "reports/year" : "route_year"
                ,"reports/year/:year" : "route_year"
                ,"reports/deviations" : "route_list"
                ,"reports/projects" : "route_projects"
                ,"reports/projects/:id/:year" : "route_project"
            },
            route_year : function(year){
                this.app().layouts.main.content.show( new View_Year({year: year}) );
            },
            route_list : function(){
                this.app().layouts.main.content.show( new View_List() );
            },
            route_projects : function(){
                this.app().layouts.main.content.show( new View_Projects() );
            },
            route_project : function(project_id, year){
                var project = this.app().collection('projects').get(project_id);
                this.app().menu.addBreadcrumb({ title: project+" ["+year+"]" });

                this.app().layouts.main.content.show( new View_Projects({
                    projectId: project_id,
                    year: year
                }) );
            }

        });

        return router;
    }
)