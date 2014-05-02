define(
    [
        'bicycle',
        './../fot-collection',
        'tpl!./fot.tpl.html',
        'tpl!./fot-report.tpl.html',
        'application',
        'i18n!nls/general',
        'i18n!./../../nls/general'
    ],
    function (Bicycle, Collection, TPL_List, TPL_Report, App, _i18n, i18n) {

        return Bicycle.Core.View.extend({
            template: TPL_List,
            _serializeAdditionalData: {
                i18n: i18n,
                _i18n: _i18n
            },

            report: new Collection(),

            onBeforeRender: function () {
                var _this = this;
                if (_(this.options).isUndefined() || _(this.options.year).isUndefined()) {
                    this.options.year = (new Date()).getFullYear();
                }

                this.report.setYear(this.options.year);
                App.loader(i18n.loadingWage, this.report.fetch()).done(function () {
                    _this.renderReport();
                });

            },

            renderReport: function () {
                this.$('.j-report').html(TPL_Report({view: this, i18n: i18n, _i18n: _i18n}));
            },

            getMonths: function(){
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
            }
        });

    }
)