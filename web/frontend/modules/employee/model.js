define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var translations = {
            secondName: "Фамилия",
            firstName: "Имя",
            status: "Статус",
            salary: "Зарплата",
            notes: "Заметки"
        }

        var model = {

            defaults: {
                secondName: "",
                firstName: "",
                status: 1,
                salary: 0,
                notes: ""
            },

            statuses: {
                "0": "Удален",
                "1": "Активен",
                "2": "Завершен"
            },

            __init: function(){
                var _this = this;
                this.registerView('show', function(){
                    return new (Helpers.View.Model.Show)({
                        model:_this,

                        exclude: ["id"],
                        translations: translations,

                        fields: {
                            status: {
                                type: "enum",
                                values: _this.statuses
                            }
                        }
                    });
                });

                this.registerView('edit', function(){
                    var view = new (Helpers.View.Model.Edit)({
                        model:_this,

                        exclude: ["id"],
                        translations: translations,

                        fields: {
                            status: {
                                type: "enum",
                                values: _this.statuses
                            },
                            description: {
                                type: "text"
                            }
                        },

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

                        fields: {
                            status: {
                                type: "enum",
                                values: _this.statuses
                            },
                            description: {
                                type: "text"
                            }
                        },

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

            toString: function(){
                return this.get('title');
            },

            linkTo: function(type){
                var links = {
                    "new": 'admin/employees/new',
                    "show": 'admin/employees/'+this.id,
                    "edit": 'admin/employees/'+this.id+'/edit'
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)