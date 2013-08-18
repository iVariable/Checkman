define(
    [
        'marionette'
    ],
    function (Marionette) {
        var Router = Marionette.AppRouter.extend({

            _app: undefined,

            app: function (app) {
                if (!_.isUndefined(app)) this._app = app;
                return this._app;
            }

        })

        return Router;
    }
)