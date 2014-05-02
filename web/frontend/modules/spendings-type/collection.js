define(
    [
        'bicycle',
        './model',
        'helpers',
        'module',
        'i18n!./nls/general'
    ],
    function (Bicycle, model, Helpers, module, i18n) {

        var collection = {
            model: model,
            url: module.config().url,

            __init: function(){
                var _this = this;
                this.registerView('list', function(){
                    return new (Helpers.View.Collection.List)({
                        model:_this,

                        exclude: ["id"],
                        translations: i18n.model,

                        title: i18n.title,
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