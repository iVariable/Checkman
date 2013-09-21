define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var fields = {
            project: {
                type: "entity",
                entityType: "projects",
                getter: "project"
            },
            employee: {
                type: "entity",
                entityType: "employees",
                getter: "employee"
            }
        };

        var translations = {
            notes: "Примечания",
            involvement: "Занятость (в процентах)",
            project: "Проект",
            employee: "Сотрудник"
        };

        var model = {

            defaults: {
                project: 1,
                employee: "",
                notes: "",
                involvement: 10
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
                            saved: function(){
                                App.router.navigate(_this.linkTo('show'),true);
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
                            saved: function(){
                                App.router.navigate(_this.linkTo('show'),true);
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

            toString: function(){
                return this.get('involvement');
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