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
            app.collection('employees').reloadCollection = function(){
                return app.loader('Загрузка сотрудников', this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('employees').reloadCollection();
            })

        });

        return Module;
    }
)