require.config({
    paths: {
        backbone: 'bower_components/backbone/backbone-min',
        underscore: 'bower_components/underscore/underscore-min',
        jquery: 'bower_components/jquery/jquery.min',
        select2: 'bower_components/select2/select2.min',
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
            deps: ['jquery', 'underscore', 'select2'],
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
        "application", "bicycle"
        ,"modules/occupation", "modules/reports", "helpers", "modules/project", "modules/employee"
        , "modules/involvement"
        , "modules/project-involvement"
    ]
});

require(
[
    'application',
    'mixins/main',
    //reports
    'modules/reports',
    //admin
    'modules/occupation', "modules/project", "modules/employee", 'modules/project-involvement',
    //involvements
    "modules/involvement"
],
function(app){

    window.CodeMonkeysBudget = app;
    app.start();

});