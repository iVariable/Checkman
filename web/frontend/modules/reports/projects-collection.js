define(
    [
        'bicycle',
        'helpers',
        'module',
        'application'
    ],
    function (Bicycle, Helpers, module, App) {

        var model = Bicycle.Core.Model.extend({

            project: function(){
                return App.collection('projects').get('project_id');
            }

        });

        var collection = {
            model: model,
            url: module.config().url,
            urlTemplate: module.config().url,

            setYear: function(year) {
                this.url = this.urlTemplate.replace(/:year/ig, year);
            },

            getProjects: function(){
                var ids = _(this.pluck('project_id')).chain().unique();
                return App.collection('projects').filter(function(project){
                    return ids.contains(project.id) || ids.contains(project.id.toString())
                });
            },

            getProjectDataByMonth: function(project, month) {
                return this.find(function(data){
                    return (data.get('project_id') == project.id) && (data.get('month') == month);
                });
            },

            getProjectTotalByMonth: function(project, month){
                var project = this.getProjectDataByMonth(project, month);
                return project?Math.round(project.get('total')):0;
            },

            getProjectTotal: function(project){
                var total = 0;
                for(var i = 1; i<13; i++){
                    total += parseInt(this.getProjectTotalByMonth(project, i));
                }
                return total;
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)