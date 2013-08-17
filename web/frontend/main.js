require.config({
    paths: {
        backbone: 'bower_components/backbone/backbone-min',
        underscore: 'bower_components/underscore/underscore-min',
        jquery: 'bower_components/jquery/jquery.min',
        marionette: 'bower_components/backbone.marionette/lib/backbone.marionette'
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
        marionette: {
            deps: ['jquery', 'underscore', 'backbone'],
            exports: 'Marionette'
        }
    },

    packages: [
        "application"
    ]
});

require(['application'], function(app){

    window.CodeMonkeysBudget = app;


});