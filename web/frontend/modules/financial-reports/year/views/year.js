define(
    [
        'marionette',
        './../projects-collection',
        'tpl!./year.tpl.html',
        'tpl!./year-report.tpl.html',
        'application',
        'i18n!./../nls/general',
        'i18n!nls/general'
    ],
    function (Marionette, Collection, TPL_List, TPL_Report, App, i18n, _i18n) {

        return Marionette.ItemView.extend({
            template: TPL_List,
            _serializeAdditionalData: {
                i18n: i18n,
                _i18n: _i18n
            },

            report: new Collection(),

            onBeforeRender: function () {
                var _this = this;
                if (_(this.options.year).isUndefined()) {
                    this.options.year = (new Date()).getFullYear();
                }
                this.report.setYear(this.options.year);
                App.loader(i18n.loadingReport, this.report.fetch()).done(function(){
                    _this.renderReport();
                });
            },

            renderReport: function(){
                this.$('.j-report-container').html(TPL_Report({view: this, i18n: i18n}));
            }
        });

    }
)