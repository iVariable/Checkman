define(
    [
        'marionette', 'backbone',

        './router', './menu/menu', './layouts/main',

        './menu',

        "module"
    ],
    function (Marionette, Backbone, Router, Menu, Layouts, MenuData, module) {

        var app = new Marionette.Application();

        app.prepareNavigation = function () {
            $('body').on('click', '.j-nav', function (e) {
                if ($(this).data('navTo')) {
                    Backbone.history.navigate($(this).data('navTo'), true);
                } else if ($(this).attr('href')) {
                    Backbone.history.navigate($(this).attr('href'), true);
                }
                e.cancelBubble = true;
                e.preventDefault();
                return false;
            });

            app.vent.on("router:route:before", function (route, params) {
                app.menu.selectedUrl(params);
                app.redrawMenu();
            });
        }

        app.redrawMenu = function(){
            app.menu.view('main').render();
            app.menu.view('secondary').render();
            app.menu.view('breadcrumbs').render();
            app.menu.view('profile').render();
        }

        app.layouts = {
            main: new (Layouts.MainLayout)({el: module.config().container})
        };

        app.menu = new Menu(MenuData, {app: app});

        app.router = new Router();
        app.router.app(app);

        app.on("initialize:after", function (options) {

            app.layouts.main.render();

            app.layouts.main.primaryMenu.draw(app.menu.view('main'));
            app.layouts.main.secondaryMenu.draw(app.menu.view('secondary'));
            app.layouts.main.profile.draw(app.menu.view('profile'));
            app.layouts.main.breadcrumbs.draw(app.menu.view('breadcrumbs'));

            if (Backbone.history) {

                app.prepareNavigation();

                Backbone.history.start();
            }

        });

        return app;

    });