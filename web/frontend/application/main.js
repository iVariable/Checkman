define(
    [
        'bicycle', 'backbone',

        './router', './menu/menu', './layouts/main',

        './menu',

        'i18n!./nls/general',
        "module"
    ],
    function (Bicycle, Backbone, Router, Menu, Layouts, MenuData, i18n, module) {

        //TODO: My eyes... rework this shit!

        var app = new Bicycle.Core.Application();

        app.user = module.config().user;
        app.user.canEditRegion = function (regionId) {
            if (_.isObject(regionId)) regionId = regionId.id;
            regionId = parseInt(regionId);
            return this.isAdmin || _(this.availableRegions).contains(regionId);
        }
        app.routes = module.config().routes;

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
            });
            app.vent.on("router:route:after", function (route, params) {
                app.redrawMenu();
            });
        }

        app.redrawMenu = function () {
            app.menu.view('main').render();
            app.menu.view('secondary').render();
            app.menu.view('breadcrumbs').render();
            app.menu.view('profile').render();
            app.menu.view('regionSelector').render();
        }

        app.loader = function (text, xhr) {
            var loaded = $.Deferred(),
                notification = Notifications.push({
                    text: text
                });

            loaded.done(function () {
                notification.notification.dismiss();
            });

            loaded.fail(function () {
                notification.notification.dismiss();
                //@TODO: Картинку с ошибкой
                Notifications.push({
                    text: i18n.error + ": <br />" + text
                });
            })

            xhr
                .done(function () {
                    loaded.resolve(xhr);
                })
                .fail(function () {
                    loaded.reject(xhr);
                })
            ;

            return loaded.promise();
        }

        app.reload = function () {
            var _this = this;
            var loaders = _(this.collections()).map(function (collection) {
                if (_.isFunction(collection.reloadCollection)) {
                    return collection.reloadCollection();
                } else {
                    return true;
                }
            });
            $.when.apply($, loaders).always(function () {
                //refresh views
                _this.redraw();
            });
        };

        app.redraw = function () {
            this.layouts.main.regionManager.each(function (region) {
                if (region.currentView)region.currentView.render();
            })
        }

        app.layouts = {
            main: new (Layouts.MainLayout)({el: module.config().container})
        };

        //Говно. Потом поправлю. Надо перенести в каждый конкретный модуль
        if (!app.user.isAdmin) {
            delete MenuData.admin.children.occupations;
            delete MenuData.admin.children.regions;
            delete MenuData.admin.children.spendingstype;
        }

        app.menu = new Menu(MenuData, {app: app, locale: module.config().locale, switchLocaleUrl: module.config().switchLocaleUrl});
        app.menu.app = app;

        app.router = new Router();
        app.router.app(app);

        app.on("initialize:after", function (options) {
            Notifications.instance = null;
            app.layouts.main.render();

            app.layouts.main.primaryMenu.draw(app.menu.view('main'));
            app.layouts.main.secondaryMenu.draw(app.menu.view('secondary'));
            app.layouts.main.profile.draw(app.menu.view('profile'));
            app.layouts.main.breadcrumbs.draw(app.menu.view('breadcrumbs'));
            app.layouts.main.regionSelector.draw(app.menu.view('regionSelector'));

            if (Backbone.history) {
                app.prepareNavigation();
                Backbone.history.start();
            }

        });

        return app;

    });