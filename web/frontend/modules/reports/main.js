define(
    [
        'bicycle',
        'application',
        './router'
    ],

    function (Bycycle, app, Router) {

        var Module = app.module('reports', function (module) {

            module.router = new Router();
            module.router.app(app);

        });

        return Module;
    }
)