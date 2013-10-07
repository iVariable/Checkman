define(
    [
        'marionette',
        './../projects-collection',
        'tpl!./year.tpl.html',
        'application'
    ],
    function (Marionette, Collection, TPL_List, App) {

        return Marionette.ItemView.extend({
            template: TPL_List,

            report: new Collection(),

            onRender: function () {
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
                this.$('.j-report-container').html("");
                var data = '',
                    _this = this,
                    projects = this.report.getProjects();

                _(projects).each(function(project){
                    data += '<tr>' +
                        '<th><a href="'+project.linkTo('finance_report_by_year', _this.options.year)+'" class="j-nav">'+project+'</a></th>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 1), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 2), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 3), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 4), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 5), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 6), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 7), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 8), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 9), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 10), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 11), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotalByMonth(project, 12), false)+'</td>'+
                        '<td>'+_.currencyFormat(_this.report.getProjectTotal(project))+'</td>'+

                    '</tr>';
                });

                this.$('.j-report-container').html(data);

            }
        });

    }
)