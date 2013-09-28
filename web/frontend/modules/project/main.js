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
            app.collection('projects').reloadCollection = function(){
                return app.loader('Загрузка проектов', this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('projects').reloadCollection();
            })

        });

        return Module;
    }
)