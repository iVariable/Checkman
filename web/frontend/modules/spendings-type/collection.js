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
                        translations: {
                            title: "Название",
                            description: "Описание"
                        },

                        title: "Тип затрат",
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
                    'new': 'admin/spendingstype/new',
                    'list': 'admin/spendingstype'
                }
                return links[type];
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)