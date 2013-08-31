define(
    [
        'bicycle',
        'application',
        './router',
        './collection'
    ],

    function (Bycycle, app, Router, Collection) {

        var Module = app.module('employee', function (module) {

            module.router = new Router();
            module.router.app(app);

            app.collection('employees', new Collection());

            app.addInitializer(function(){
                return app.loader('Загрузка сотрудников', app.collection('employees').fetch());
            })

        });

        return Module;
    }
)