define(
    [
        'marionette',
        './../project-summary-collection',
        'tpl!./projects.tpl.html',
        'tpl!./projects-month-report.tpl.html',
        'application'
    ],
    function (Marionette, Collection, TPL_List, TPL_Report, App) {

        return Marionette.ItemView.extend({
            template: TPL_List,

            report: new Collection(),


            onBeforeRender: function () {
                var _this = this;
                if (_(this.options).isUndefined() || _(this.options.year).isUndefined()) {
                    this.options.year = (new Date()).getFullYear();
                }

                if (!_(this.options.projectId).isUndefined()) {
                    this.report.setProjectAndYear(this.options.projectId, this.options.year);
                    App.loader('Загрузка отчета по проекту...', this.report.fetch()).done(function () {
                        _this.renderReport();
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

                this.$('.j-report-container').html("Загрузил");

                this.$('.j-report-by-type').html(TPL_Report({view: this}));

            },

            getMonths: function(){
                var months = [
                    'Январь',
                    'Февраль',
                    'Март',
                    'Апрель',
                    'Май',
                    'Июнь',
                    'Июль',
                    'Август',
                    'Сентябрь',
                    'Октябрь',
                    'Ноябрь',
                    'Декабрь'
                ];

                return months;
            },

            getSpendingTypes: function() {
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