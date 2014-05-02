define(
    [
        'bicycle',
        'application',
        './router',
        './collection',
        'i18n!./nls/general'
    ],

    function (Bycycle, app, Router, Collection, i18n) {

        var Module = app.module('spendingstype', function (module) {

            module.router = new Router();
            module.router.app(app);

            app.collection('spendingstypes', new Collection());
            app.collection('spendingstypes').reloadCollection = function(){
                return app.loader(i18n.loadingCollection, this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('spendingstypes').reloadCollection();
            })

        });

        return Module;
    }
)