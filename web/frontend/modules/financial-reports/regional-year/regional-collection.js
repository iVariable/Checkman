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

            setIdAndYear: function(id,year) {
                this.url = this.urlTemplate.replace(/:year/ig, year).replace(/:id/ig, id);
            },

            spendingTypeTitles: function(){
                return _(_(this.pluck('type')).unique());
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)