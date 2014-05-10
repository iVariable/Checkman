define(
    [
        'marionette',
        './../project-summary-collection',
        './../project-overall.model',
        'tpl!./project-overall.tpl.html',
        'tpl!./projects.tpl.html',
        'tpl!./projects-month-report.tpl.html',
        'application',
        'i18n!./../../nls/general',
        'i18n!nls/general'
    ],
    function (Marionette, Collection, OverallModel, TPL_OverallReport, TPL_List, TPL_Report, App, i18n, _i18n) {

        return Marionette.ItemView.extend({
            template: TPL_List,
            _serializeAdditionalData: {
                i18n: i18n,
                _i18n: _i18n
            },

            report: new Collection(),
            overallReport: new OverallModel(),

            onBeforeRender: function () {
                var _this = this;
                if (_(this.options).isUndefined() || _(this.options.year).isUndefined()) {
                    this.options.year = (new Date()).getFullYear();
                }

                if (!_(this.options.projectId).isUndefined()) {
                    this.report.setProjectAndYear(this.options.projectId, this.options.year);
                    App.loader(i18n.loadingProjectReport, this.report.fetch()).done(function () {
                        _this.renderReport();
                    });

                    this.overallReport.setProjectId(this.options.projectId);
                    App.loader(i18n.loadingProjectOverallReport, this.overallReport.fetch()).done(function () {
                        _this.renderOverallReport();
                    });
                }
            },

            renderReport: function () {

                var data = this._formDataByMonths(this.report);

                $.plot("#graph_placeholder", [ data ], {
                    series: {
                        bars: {
                            show: true,
                            barWidth: 0.6,
                            align: "center"
                        }
                    },
                    xaxis: {
                        mode: "categories",
                        tickLength: 0
                    }
                });

                this.$('.j-report-container').html("Loaded");

                this.$('.a-report-by-type').html(TPL_Report({view: this, i18n: i18n, _i18n: _i18n}));

            },

            renderOverallReport: function () {
                this.$('.a-report-overall-stats').html(TPL_OverallReport({view: this, i18n: i18n, _i18n: _i18n}));
            },

            getMonths: function () {
                var months = [
                    i18n.months.jan,
                    i18n.months.feb,
                    i18n.months.mar,
                    i18n.months.apr,
                    i18n.months.may,
                    i18n.months.jun,
                    i18n.months.jul,
                    i18n.months.aug,
                    i18n.months.sep,
                    i18n.months.oct,
                    i18n.months.nov,
                    i18n.months.dec
                ];

                return months;
            },

            getSpendingTypes: function () {
                var types = this.report.pluck('type');
                return _.unique(types);
            },

            _formDataByMonths: function (report) {
                var data = [],
                    months = this.getMonths()
                    ;

                for (var i = 1; i < 13; i++) {
                    var monthCost = this.report.getTotalByMonth(i);

                    data.push([months[i - 1], monthCost ]);
                }
                ;

                return data;
            }
        });

    }
)