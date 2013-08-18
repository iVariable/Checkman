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
            },

            before: function(route, params){
                this._before.call(this);
                this.app().vent.trigger('router:route:before', route, params);
            },

            _before: function(){},

            after: function(route, params){
                this._after.call(this);
                this.app().vent.trigger('router:route:after', route, params);
            },

            _after: function(){}

        })

        return Router;
    }
)