define(
    [
        'bicycle',
        'application',
        './router',
        './collection',
        './model'
    ],

    function (Bycycle, app, Router, Collection, Model) {

        var Module = app.module('projectInvolvement', function (module) {

            module.Model = Model;
            module.Collection = Collection;

            app.collection('projectInvolvements', new Collection());
            app.collection('projectInvolvements').reloadCollection = function(){
                return app.loader('Загрузка занятости', this.fetch());
            };

            app.addInitializer(function(){
                return app.collection('projectInvolvements').reloadCollection();
            })

        });

        return Module;
    }
)