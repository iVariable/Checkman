define(
    [
        'marionette',
        './../project-month-details-collection',
        'tpl!./project-details.tpl.html',
        'tpl!./project-details-report.tpl.html',
        'application'
    ],
    function (Marionette, Collection, TPL_List, TPL_Report, App) {

        return Marionette.ItemView.extend({
            template: TPL_List,

            report: new Collection(),


            onRender: function () {
                var _this = this;
                if (_(this.options).isUndefined() || _(this.options.year).isUndefined()) {
                    this.options.year = (new Date()).getFullYear();
                }

                if (!_(this.options.project).isUndefined()) {
                    this.report.setProjectAndYearAndMonth(this.options.project.id, this.options.year, this.options.month);
                    App.loader('Загрузка отчета по проекту...', this.report.fetch()).done(function () {
                        _this.renderReport();
                    });
                }
                window.v = this;
            },

            renderReport: function () {
                this.$('.j-report').html(TPL_Report({view: this}));
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
            }
        });

    }
)