define(
    [
        'bicycle',
        'helpers',
        'module',
        'application'
    ],
    function (Bicycle, Helpers, module, App) {

        var model = Bicycle.Core.Model.extend({
            employee: function () {
                return App.collection('employees').get(this.get('employee_id'));
            }
        });

        var collection = {
            model: model,
            url: module.config().url,
            urlTemplate: module.config().url,

            setProjectAndYearAndMonth: function (projectId, year, month) {
                this.url = this.urlTemplate.replace(/:year/ig, year).replace(/:id/ig, projectId).replace(/:month/ig, month);
            },

            getTypes: function () {
                var types = _(this.pluck('type_id')).unique();
                return _(App.collection('spendingstypes').filter(function (type) {
                    return (types.indexOf(type.id) !== -1) || (types.indexOf(type.id.toString()) !== -1);
                }));
            },

            getByType: function (type) {
                return _(
                    this
                        .filter(function (elem) {
                            return elem.get('type_id') == type.id;
                        })
                );
            },

            getTotalByType: function (type) {
                var total = this
                        .getByType(type)
                        .reduceRight(function (sum, elem) {
                            sum += Math.round(elem.get("total"));
                            return sum;
                        }, 0)
                    ;
                return total;
            },

            getTotal: function () {
                return this.reduceRight(function (sum, elem) {
                    sum += Math.round(elem.get("total"));
                    return sum;
                }, 0);
            }

        }

        return Bicycle.Core.Collection.extend(collection);
    }
)