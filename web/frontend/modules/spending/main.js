define(
    [
        'bicycle',
        'application',

        './collection',
        './model'
    ],

    function (Bycycle, app, Collection, Model) {

        var Module = app.module('spendings', function (module) {

            module.Model = Model;
            module.Collection = Collection;

        });

        return Module;
    }
)