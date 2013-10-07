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

            setProjectAndYearAndMonth: function(projectId, year, month) {
                this.url = this.urlTemplate.replace(/:year/ig, year).replace(/:id/ig, projectId).replace(/:month/ig, month);
            }

        }

        return Bicycle.Core.Collection.extend(collection);
    }
)