define(
    [
        'marionette',

        './menu/menu',

        "tpl!./layouts/main.tpl.html",

        "module"
    ],
    function (Marionette, Menu, Tpl_MainLayout, module) {

        var app = new Marionette.Application();

        var MainLayout = Marionette.Layout.extend({
            el: module.config().container,

            template: Tpl_MainLayout,

            regions: {
                primaryMenu: "#primary",
                secondaryMenu: "#secondary",
                crumbs: "#main>.top-nav",
                container: "#main>.a-main-container"
            }
        });

        app.layouts = {
            main: new MainLayout()
        };

        app.menu = new Menu({app: app});


        app.addInitializer(function(){
            app.layouts.main.render();

            app.layouts.main.primaryMenu.draw(app.menu.view('main'));
            app.layouts.main.secondaryMenu.draw(app.menu.view('secondary'));

        });


        return app;

    });