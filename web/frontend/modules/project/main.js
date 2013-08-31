define(
    [
        'bicycle',
        'application',
        './router',
        './collection'
    ],

    function (Bycycle, app, Router, Collection) {

        var Module = app.module('project', function (module) {

            module.router = new Router();
            module.router.app(app);

            app.collection('projects', new Collection());

            app.addInitializer(function(){
                return app.loader('Загрузка проектов', app.collection('projects').fetch());
            })

        });

        return Module;
    }
)