define(
    [
        'marionette',

        './menu',

        './menu/menu',
        './layouts/main',

        "module"
    ],
    function (Marionette, MenuData, Menu, Layouts, module) {

        var app = new Marionette.Application();


        app.layouts = {
            main: new (Layouts.MainLayout)({el: module.config().container})
        };

        app.menu = new Menu({app: app});
        app.menu.menu(MenuData);

        app.addInitializer(function(){
            app.layouts.main.render();

            app.layouts.main.primaryMenu.draw(app.menu.view('main'));
            app.layouts.main.secondaryMenu.draw(app.menu.view('secondary'));
            app.layouts.main.profile.draw(app.menu.view('profile'));
            app.layouts.main.breadcrumbs.draw(app.menu.view('breadcrumbs'));
        });


        return app;

    });