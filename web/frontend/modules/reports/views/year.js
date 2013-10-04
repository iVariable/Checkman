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
                        '<td>'+_this.report.getProjectTotalByMonth(project, 1)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 2)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 3)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 4)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 5)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 6)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 7)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 8)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 9)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 10)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 11)+'</td>'+
                        '<td>'+_this.report.getProjectTotalByMonth(project, 12)+'</td>'+
                        '<td>'+_this.report.getProjectTotal(project)+'</td>'+

                    '</tr>';
                });

                this.$('.j-report-container').html(data);

            }
        });

    }
)