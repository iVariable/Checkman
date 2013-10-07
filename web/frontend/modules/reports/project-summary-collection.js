define(
    [
        'bicycle',
        'helpers',
        'module',
        'application'
    ],
    function (Bicycle, Helpers, module, App) {

        var model = Bicycle.Core.Model.extend({

        });

        var collection = {
            model: model,
            url: module.config().url,
            urlTemplate: module.config().url,

            setProjectAndYear: function(projectId, year) {
                this.url = this.urlTemplate.replace(/:year/ig, year).replace(/:id/ig, projectId);
            },

            getTotalByTypeAndMonth: function(type, month) {
                var sum = this.reduceRight(function (sum, cost) {
                    if ((cost.get('month') == month)&&(cost.get('type') == type)) sum += Math.round(cost.get("total"));
                    return sum;
                }, 0)
                return sum;
            },

            getTotalByMonth: function(month){
                var sum = this.reduceRight(function (sum, cost) {
                    if (cost.get('month') == month) sum += Math.round(cost.get("total"));
                    return sum;
                }, 0)
                return sum;
            }

        }

        return Bicycle.Core.Collection.extend(collection);
    }
)