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

                        exclude: ["id"],
                        translations: {
                            title: i18n.title
                        },

                        title: i18n.specializations,
                        callbacks: {
                            removed: function(){
                                _this.render('list');
                            }
                        }
                    });
                })
            },

            linkTo: function(type){
                var links = {
                    'new': 'admin/occupations/new',
                    'list': 'admin/occupations'
                }
                return links[type];
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)