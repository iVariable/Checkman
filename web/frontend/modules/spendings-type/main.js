define(
    [
        'bicycle',
        'application',
        './router',
        './collection'
    ],

    function (Bycycle, app, Router, Collection) {

        var Module = app.module('spendingstype', function (module) {

            module.router = new Router();
            module.router.app(app);

            app.collection('spendingstypes', new Collection());
            app.collection('spendingstypes').reloadCollection = function(){
                return app.loader('Загрузка типов затрат', this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('spendingstypes').reloadCollection();
            })

        });

        return Module;
    }
)