define(
    [
        'bicycle',
        'helpers',
        'module',
        'application'
    ],
    function (Bicycle, Helpers, module, App) {
        var model = Bicycle.Core.Model.extend({});

        var collection = {
            model: model,
            url: module.config().url,
            urlTemplate: module.config().url,

            setId: function(id,year) {
                this.url = this.urlTemplate.replace(/:id/ig, id);
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)