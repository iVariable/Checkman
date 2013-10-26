define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var fields = {
            date: {
                type: "date"
            },
            project_id: {
                type: "entity",
                entityType: "projects",
                getter: "project"
            },
            employee_id: {
                type: "entity",
                entityType: "employees",
                getter: "employee"
            },
            type_id: {
                type: "entity",
                entityType: "spendingsType",
                getter: "type"
            }
        };

        var translations = {
            date: "Дата",
            description: "Примечания",
            value: "Сумма",
            project_id: "Проект",
            employee_id: "Сотрудник",
            type_id: "Тип затрат"
        };

        var model = {

            defaults: {
                date: 1,
                employee_id: false,
                type_id: false,
                project_id: false,
                description: "",
                value: 0
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
                return App.collection('employees').get(this.get('employee_id'));
            },

            project: function(){
                return App.collection('projects').get(this.get('project_id'));
            },

            type: function(){
                return App.collection('spendingsType').get(this.get('type_id'));
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