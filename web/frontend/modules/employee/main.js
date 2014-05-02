define(
    [
        'bicycle',
        'application',
        './router',
        './collection',
        'i18n!./nls/general'
    ],

    function (Bycycle, app, Router, Collection, i18n) {

        var Module = app.module('employee', function (module) {

            module.router = new Router();
            module.router.app(app);

            app.collection('employees', new Collection());
            app.collection('employees').reloadCollection = function(){
                return app.loader(i18n.loadingCollection, this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('employees').reloadCollection();
            })

        });

        return Module;
    }
)