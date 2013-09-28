define(
    [
        'bicycle',
        'application',
        './router',
        './projects-collection'
    ],

    function (Bycycle, app, Router, ProjectsCollection) {

        var Module = app.module('reports', function (module) {

            module.router = new Router();
            module.router.app(app);

            module.ProjectsCollection = ProjectsCollection;

        });

        return Module;
    }
)