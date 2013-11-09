define(
    [
        'bicycle',
        'helpers',
        'module',
        'application'
    ],
    function (Bicycle, Helpers, module, App) {

        var model = Bicycle.Core.Model.extend({
            employee: function(){
                return App.collection('employees').get(this.get('employee_id'));
            }
        });

        var collection = {
            model: model,
            url: module.config().url,
            urlTemplate: module.config().url,

            setYear: function(year) {
                this.url = this.urlTemplate.replace(/:year/ig, year);
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)