define(
    [
        'bicycle',
        'application',
        './router',
        './collection'
    ],

    function (Bycycle, app, Router, Collection) {

        var Module = app.module('region', function (module) {

            if(app.user.isAdmin){
                module.router = new Router();
                module.router.app(app);
            }

            app.collection('regions', new Collection());
            app.collection('regions').reloadCollection = function(){
                return app.loader('Загрузка регионов', this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('regions').reloadCollection();
            })

        });

        return Module;
    }
)