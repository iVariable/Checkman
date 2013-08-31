require.config({
    paths: {
        backbone: 'bower_components/backbone/backbone-min',
        underscore: 'bower_components/underscore/underscore-min',
        jquery: 'bower_components/jquery/jquery.min',
        marionette: 'bower_components/backbone.marionette/lib/backbone.marionette',
        text: 'bower_components/requirejs-text/text',
        tpl: 'bower_components/requirejs-tpl/tpl',
        backbone_routefilter: 'bower_components/backbone.routefilter/dist/backbone.routefilter.min'
    },
    shim: {
        jquery: {
            exports: 'jQuery'
        },
        underscore: {
            exports: '_'
        },
        backbone: {
            deps: ['jquery', 'underscore'],
            exports: 'Backbone'
        },
        backbone_routefilter: {
            deps: ['backbone']
        },
        marionette: {
            deps: ['jquery', 'underscore', 'backbone', 'backbone_routefilter'],
            exports: 'Marionette'
        }
    },

    packages: [
        "application", "bicycle", "modules/occupation", "modules/reports", "helpers", "modules/project", "modules/employee"
    ]
});

require(
[
    'application',
    'mixins/main',
    'modules/occupation', 'modules/reports', "modules/project", "modules/employee"
],
function(app){

    window.CodeMonkeysBudget = app;
    app.start();

});