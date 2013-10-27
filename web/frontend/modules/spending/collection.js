define(
    [
        'bicycle',
        './model',
        'helpers',
        'backbone_actas_paginatable',
        './views/edit-list',
        'module'
    ],
    function (Bicycle, model, Helpers, Paginatable, View_EditList, module) {

        var collection = {
            model: model,
            urlRoot: module.config().url,
            modelUrlRoot: module.config().url,

            __init: function(){
                var _this = this;
                this.registerView('edit-list', function(){
                    var view = new View_EditList({
                        model: _this
                    });

                    view.on('render', function(){
                        view.delegateEvents();
                    })
                    return view;
                })
            },

            comparator: function(a, b){
                return a.get('date') > b.get('date')?1:-1;
            }
        }

        collection = Bicycle.Core.Collection.extend(collection);

        Paginatable.init(collection, model);

        return collection;
    }
)