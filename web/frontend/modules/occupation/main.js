define(
    [
        'bicycle',
        'application',
        './router',
        './collection'
    ],

    function (Bycycle, app, Router, Collection) {

        var Module = app.module('occupation', function (module) {

            module.router = new Router();
            module.router.app(app);

            app.collection('occupations', new Collection());
            app.collection('occupations').reloadCollection = function(){
                return app.loader('Загрузка специализаций', this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('occupations').reloadCollection();
            })

        });

        return Module;
    }
)