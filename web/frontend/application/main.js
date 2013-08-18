define(
    [
        'marionette', 'backbone',

        './router', './menu/menu', './layouts/main',

        './menu',

        "module"
    ],
    function (
        Marionette, Backbone,

        Router, Menu, Layouts,

        MenuData,

        module
    ) {

        var app = new Marionette.Application();

        app.layouts = {
            main: new (Layouts.MainLayout)({el: module.config().container})
        };

        app.menu = new Menu(MenuData, {app: app});

        app.router = new Router();
        app.router.app(app);

        app.on("initialize:after", function(options){

            app.layouts.main.render();

            app.layouts.main.primaryMenu.draw(app.menu.view('main'));
            app.layouts.main.secondaryMenu.draw(app.menu.view('secondary'));
            app.layouts.main.profile.draw(app.menu.view('profile'));
            app.layouts.main.breadcrumbs.draw(app.menu.view('breadcrumbs'));

            if (Backbone.history){
                Backbone.history.start();
            }

        });

        return app;

    });