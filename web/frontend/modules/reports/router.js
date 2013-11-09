define(
    [
        'bicycle',

        './year/views/year'
        ,'./views/list'
        ,'./project-summary/views/projects'
        ,'./project-month/views/project-details'
        ,'./fot/views/fot'
    ],
    function(
        Bicycle,

        View_Year
        ,View_List
        ,View_Projects
        ,View_ProjectDetails
        ,View_FOT

    ){
        var router = Bicycle.Core.Router.extend({
            routes : {
                "reports/year" : "route_year"
                ,"reports/year/:year" : "route_year"
                ,"reports/deviations" : "route_list"
                ,"reports/fot" : "route_fot"
                ,"reports/fot/:year" : "route_fot"
                ,"reports/projects" : "route_projects"
                ,"reports/projects/:id/:year" : "route_project"
                ,"reports/projects/:id/:year/:month" : "route_project_detail"
            },
            route_year : function(year){
                this.app().layouts.main.content.show( new View_Year({year: year}) );
            },
            route_fot : function(year){
                this.app().layouts.main.content.show( new View_FOT({year: year}) );
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
                    project: project,
                    projectId: project_id,
                    year: year
                }) );
            },
            route_project_detail : function(project_id, year, month){
                var project = this.app().collection('projects').get(project_id);
                this.app().menu.addBreadcrumb({ title: project+" ["+year+"]", url: project.linkTo('finance_report_by_year', year) });
                this.app().menu.addBreadcrumb({ title: month  });

                this.app().layouts.main.content.show( new View_ProjectDetails({
                    project: project,
                    year: year,
                    month: month
                }) );
            }

        });

        return router;
    }
)