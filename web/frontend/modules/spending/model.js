define(
    ['bicycle', 'helpers', 'application', 'i18n!./nls/general', 'i18n!nls/general'],
    function (Bicycle, Helpers, App, i18n, _i18n) {

        var fields = {
            date: {
                type: "date"
            },
            description: {
                type: 'text'
            },
            project: {
                type: "entity",
                entityType: "projects",
                getter: "project"
            },
            employee: {
                type: "entity",
                entityType: "employees",
                getter: "employee",
                nullable: true
            },
            type: {
                type: "entity",
                entityType: "spendingstypes",
                entityAllowed: function(model){
                    return model.id != 0;
                },
                getter: "type"
            }
        };

        var translations = i18n.model;

        var model = {

            defaults: {
                date: 1,
                employee: false,
                type: false,
                project: false,
                description: "",
                value: "0"
            },

            __init: function(){
                var _this = this;
                this.registerView('show', function(){
                    return new (Helpers.View.Model.Show)({
                        model:_this,

                        exclude: ["id"],
                        translations: translations,

                        fields: fields
                    });
                });

                this.registerView('edit', function(){
                    var view = new (Helpers.View.Model.Edit)({
                        model:_this,

                        exclude: ["id"],
                        translations: translations,

                        fields: fields,

                        drawAsWindow: true,

                        callbacks: {
                            saving: function(xhr){
                                App.loader(_i18n.actions.saving, xhr);
                            }
                        }
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
                        callbacks: {
                            saving: function(xhr){
                                App.loader(_i18n.actions.saving, xhr);
                            }
                        }
                    });

                    view.on('render', function(){
                        view.delegateEvents();
                    })
                    return view;
                })
            },

            employee: function(){
                return App.collection('employees').get(this.get('employee'));
            },

            project: function(){
                return App.collection('projects').get(this.get('project'));
            },

            type: function(){
                return App.collection('spendingstypes').get(this.get('type'));
            },

            toString: function(){
                return this.get('value');
            },

            linkTo: function(type){
                var links = {
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)