define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var translations = {
            title: "Название",
            description: "Описание"
        };

        var fields = {
            description: {
                type: "text"
            }
        };

        var callbacks = {
            saving: function(savingDeferred){
                App.loader('Сохранение', savingDeferred);
            },

            saved: function(){
                App.router.navigate(this.linkTo('show'),true);
            }
        };

        var model = {

            defaults: {
                title: "Новый тип затрат"
                ,description: ""
            },

            __init: function(){
                var _this = this;
                this.registerView('show', function(){
                    return new (Helpers.View.Model.Show)({
                        model:_this,

                        exclude: ["id"],
                        translations: translations
                    });
                });

                this.registerView('edit', function(){
                    var view = new (Helpers.View.Model.Edit)({
                        model:_this,

                        exclude: ["id"],
                        translations: translations,

                        fields: fields,

                        callbacks: callbacks
                    });

                    view.on('render', function(){
                        view.delegateEvents();
                    })
                    return view;
                })

                this.registerView('new', function(){
                    var view = new (Helpers.View.Model.New)({
                        model:_this,

                        exclude: ["id"],
                        translations: translations,

                        fields: fields,

                        callbacks: callbacks
                    });

                    view.on('render', function(){
                        view.delegateEvents();
                    })
                    return view;
                })
            },

            toString: function(){
                return this.get('title');
            },

            linkTo: function(type){
                var links = {
                    "new": 'admin/spendingstype/new',
                    "show": 'admin/spendingstype/'+this.id,
                    "edit": 'admin/spendingstype/'+this.id+'/edit'
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)