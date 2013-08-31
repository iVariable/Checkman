define(
    [
        'bicycle',
        './model',
        'helpers',
        'module'
    ],
    function (Bicycle, model, Helpers, module) {

        var collection = {
            model: model,
            url: module.config().url,

            __init: function(){
                var _this = this;
                this.registerView('list', function(){
                    return new (Helpers.View.Collection.List)({
                        model:_this,

                        exclude: ["id"],
                        translations: _this.model.prototype.translations,

                        fields: _this.model.prototype.fields,

                        title: "Сотрудники",
                        callbacks: {
                            removed: function(){
                                _this.render();
                            }
                        }
                    });
                })
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