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

            app.addInitializer(function(){
                return app.loader('Загрузка занятости', app.collection('projectInvolvements').fetch());
            })

        });

        return Module;
    }
)