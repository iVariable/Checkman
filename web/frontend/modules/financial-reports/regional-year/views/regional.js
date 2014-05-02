define(
    [
        'bicycle',
        './../regional-collection',
        'tpl!./regional.tpl.html',
        'tpl!./regional-report.tpl.html',
        'application'
    ],
    function (Bicycle, Collection, TPL_List, TPL_Report, App) {

        return Bicycle.Core.View.extend({
            template: TPL_List,

            report: new Collection(),

            onRender: function () {
                var _this = this;
                if (_(this.options).isUndefined() || _(this.options.year).isUndefined()) {
                    this.options.year = (new Date()).getFullYear();
                }
                if(!_(this.options.id).isUndefined()){
                    this.report.setIdAndYear(this.options.id, this.options.year);
                    App.loader('Загрузка регионального годового отчета...', this.report.fetch()).done(function () {
                        _this.renderReport();
                    });
                }
            },

            renderReport: function () {
                this.$('.j-report').html(TPL_Report({view: this, app: App}));
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

            linkTo: function(id, year){
                return 'reports/regional/'+id+'/'+year;
            }
        });

    }
)