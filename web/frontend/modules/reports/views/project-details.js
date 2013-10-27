define(
    [
        'bicycle',
        './../project-month-details-collection',
        'tpl!./project-details.tpl.html',
        'tpl!./project-details-report.tpl.html',
        'application'
    ],
    function (Bicycle, Collection, TPL_List, TPL_Report, App) {

        return Bicycle.Core.View.extend({
            template: TPL_List,

            report: new Collection(),

            events: {
                'click .j-add-spendings': 'event_addSpendings'
            },

            regions: {
                "newSpendingsContainer": '.j-spendings-add-container',
                "reportContainer": '.j-report'
            },

            event_addSpendings: function(){
                var collection = new (App.module('spendings')).Collection();
                var currentDate = new Date();
                console.log(this.options );
                if(this.options.year == currentDate.getFullYear() && this.options.month == (currentDate.getMonth()+1)){
                    var date = moment();
                }else{
                    var date = moment('01-'+this.options.month+'-'+this.options.year, 'DD-MM-YYYY');
                }
                var model = collection.createEntity({
                    project: this.options.project.id,
                    date: date.format('DD-MM-YYYY')
                });
                model.view("new").save2collection = collection;
                model.view("new").options.fields.project.fixed = true;
                model.view("new").options.callbacks.saved = function(){
                    App.reload();
                };
                this.newSpendingsContainer.show(model.view("new"));
            },

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
                this.reportContainer.html(TPL_Report({view: this}));
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