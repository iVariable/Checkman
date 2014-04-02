define(
    [
        'marionette',
        './../projects-collection',
        'tpl!./year.tpl.html',
        'tpl!./year-report.tpl.html',
        'application'
    ],
    function (Marionette, Collection, TPL_List, TPL_Report, App) {

        return Marionette.ItemView.extend({
            template: TPL_List,

            report: new Collection(),

            onBeforeRender: function () {
                var _this = this;
                if (_(this.options.year).isUndefined()) {
                    this.options.year = (new Date()).getFullYear();
                }
                this.report.setYear(this.options.year);
                App.loader('Загрузка годового отчета...', this.report.fetch()).done(function(){
                    _this.renderReport();
                });
            },

            renderReport: function(){
                this.$('.j-report-container').html(TPL_Report({view: this}));
            }
        });

    }
)