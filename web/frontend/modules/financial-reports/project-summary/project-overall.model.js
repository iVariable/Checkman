define(
    [
        'bicycle',
        'module',
        'application'
    ],
    function (Bicycle, module, App) {

        var model = Bicycle.Core.Model.extend({
            urlTemplate: module.config().url,

            setProjectId: function(projectId){
                this.projectId = projectId;
                this.url = this.urlTemplate.replace(/:id/ig, projectId);
            },

            getProject: function() {
                return App.collection('projects').get(this.projectId);
            },

            getOverallSpendings: function(){
                return _(this.get('overallSpendings')).reduce(function(sum, elem){ return sum + elem}, 0);
            },

            getDateStart: function(){
                return this.get('dateStart').year+'-'+this.get('dateStart').month+"-"+this.get('dateStart').day;
            }
        });
        return model;
    }
)