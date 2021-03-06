require.config({
    paths: {
        backbone: 'bower_components/backbone/backbone-min',
        underscore: 'bower_components/underscore/underscore-min',
        //jquery: 'bower_components/jquery/jquery.min',
        select2: 'bower_components/select2/select2.min',
        marionette: 'bower_components/backbone.marionette/lib/backbone.marionette',
        text: 'bower_components/requirejs-text/text',
        tpl: 'bower_components/requirejs-tpl/tpl',
        i18n: 'bower_components/requirejs-i18n/i18n',
        backbone_routefilter: 'bower_components/backbone.routefilter/dist/backbone.routefilter.min',
        backbone_actas_paginatable: 'bower_components/backbone.actas.paginatable/src/Backbone.actAs.Paginatable',
        moment: 'bower_components/momentjs/moment',
        nls: 'nls'
    },
    shim: {
        jquery: {
            exports: 'jQuery'
        },
        underscore: {
            exports: '_'
        },
        backbone: {
            deps: ['jquery', 'underscore', 'select2', 'moment'],
            exports: 'Backbone'
        },
        backbone_actas_paginatable: {
            deps: ['backbone'],
            exports: "Backbone.actAs.Paginatable"
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
        , "modules/occupation", "modules/financial-reports", "helpers", "modules/project", "modules/region", "modules/employee", "modules/spendings-type", "modules/spending"
        , "modules/report-involvement"
        , "modules/project-involvement"
    ]
});

require(
    [
        'application',
        'mixins/main',
        //reports
        'modules/financial-reports',
        //admin
        'modules/region', 'modules/occupation', "modules/project", "modules/employee",
        'modules/project-involvement', "modules/spendings-type", "modules/spending",
        //involvements
        "modules/report-involvement"
    ],
    function (app) {

        window.CodeMonkeysBudget = app;
        app.start();

    });