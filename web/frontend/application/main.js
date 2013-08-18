define(
[
    'marionette',

    "tpl!./layouts/main.tpl.html",

    "module"
],
function(
    Marionette,

    Tpl_MainLayout,

    module
){

    var app = new Marionette.Application();

    app.addRegions({
        container: module.config().container
    });

    var MainLayout = Marionette.Layout.extend({
        template: Tpl_MainLayout
    })

    app.layouts = {
        main: new MainLayout()
    };

    app.container.show(app.layouts.main);

    return app;

});