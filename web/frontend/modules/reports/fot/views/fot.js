define(
    [
        'bicycle',
        './../fot-collection',
        'tpl!./fot.tpl.html',
        'tpl!./fot-report.tpl.html',
        'application'
    ],
    function (Bicycle, Collection, TPL_List, TPL_Report, App) {

        return Bicycle.Core.View.extend({
            template: TPL_List,

            report: new Collection(),

            onBeforeRender: function () {
                var _this = this;
                if (_(this.options).isUndefined() || _(this.options.year).isUndefined()) {
                    this.options.year = (new Date()).getFullYear();
                }

                this.report.setYear(this.options.year);
                App.loader('Загрузка ФОТ за год...', this.report.fetch()).done(function () {
                    _this.renderReport();
                });

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