define(
    ['bicycle', 'helpers', 'application', 'i18n!nls/general', 'i18n!./nls/general'],
    function (Bicycle, Helpers, App, _i18n, i18n) {

        var translations = i18n.model;

        var fields = {
            description: {
                type: "text"
            }
        };

        var callbacks = {
            saving: function(savingDeferred){
                App.loader(_i18n.actions.saving, savingDeferred);
            },

            saved: function(){
                App.router.navigate(this.linkTo('show'),true);
            }
        };

        var model = {

            defaults: {
                title: i18n.newModel
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