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
                    return new (Helpers.View.Collection.List)({model:_this});
                })
            },

            linkTo: function(type){
                var links = {
                    'new': 'admin/occupations/new'
                }
                return links[type];
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)