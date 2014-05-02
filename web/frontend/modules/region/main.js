define(
    [
        'bicycle',
        'application',
        './router',
        './collection',
        'i18n!./nls/general'
    ],

    function (Bycycle, app, Router, Collection, i18n) {

        var Module = app.module('region', function (module) {

            if(app.user.isAdmin){
                module.router = new Router();
                module.router.app(app);
            }

            app.collection('regions', new Collection());
            app.collection('regions').reloadCollection = function(){
                return app.loader(i18n.loadingCollection, this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('regions').reloadCollection();
            })

        });

        return Module;
    }
)