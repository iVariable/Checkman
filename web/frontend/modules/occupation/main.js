define(
    [
        'bicycle',
        'application',
        './router',
        './collection',
        'i18n!./nls/general'
    ],

    function (Bycycle, app, Router, Collection, i18n) {

        var Module = app.module('occupation', function (module) {

            module.router = new Router();
            module.router.app(app);

            app.collection('occupations', new Collection());
            app.collection('occupations').reloadCollection = function(){
                return app.loader(i18n.loadingCollection, this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('occupations').reloadCollection();
            })

        });

        return Module;
    }
)