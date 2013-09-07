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

        });

        return Module;
    }
)