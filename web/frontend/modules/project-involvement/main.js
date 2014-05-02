define(
    [
        'bicycle',
        'application',
        './router',
        './collection',
        './model',
        'i18n!./nls/general'
    ],

    function (Bycycle, app, Router, Collection, Model, i18n) {

        var Module = app.module('projectInvolvement', function (module) {

            module.Model = Model;
            module.Collection = Collection;

            app.collection('projectInvolvements', new Collection());
            app.collection('projectInvolvements').reloadCollection = function(){
                return app.loader(i18n.loadingCollection, this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('projectInvolvements').reloadCollection();
            })

        });

        return Module;
    }
)