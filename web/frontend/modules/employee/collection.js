define(
    [
        'bicycle',
        './model',
        'helpers',
        'i18n!./nls/general',
        'module'
    ],
    function (Bicycle, model, Helpers, i18n, module) {

        var collection = {
            model: model,
            url: module.config().url,

            __init: function(){
                var _this = this;
                this.registerView('list', function(){
                    return new (Helpers.View.Collection.List)({
                        model:_this,

                        exclude: ["id", "notes"],
                        translations: _this.model.prototype.translations,

                        fields: _this.model.prototype.fields,

                        filterBy: function(model) {
                            return model.toString().toLowerCase();
                        },

                        title: i18n.employees,
                        callbacks: {
                            removed: function(){
                                _this.render();
                            }
                        }
                    });
                })
            },

            active: function(){
                return _(this.filter(function(elem){
                    return elem.get('status') != 0;
                }));
            },

            comparator: function(elem){
                return elem.toString();
            },

            linkTo: function(type){
                var links = {
                    'new': 'admin/employees/new',
                    'list': 'admin/employees'
                }
                return links[type];
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)