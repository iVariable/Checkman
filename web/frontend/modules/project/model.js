define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var model = {

            defaults: {
                title: "Новый проект",
                status: 1,
                description: ""
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
                        translations: {
                            title: "Название",
                            status: "Статус",
                            description: "Описание"
                        },

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
                        translations: {
                            title: "Название",
                            status: "Статус",
                            description: "Описание"
                        },

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
                        translations: {
                            title: "Название",
                            status: "Статус",
                            description: "Описание"
                        },

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

            employees: function(){
                var _this = this;
                return App.collection('employees').filter(function(employee){
                    return employee.involvement(_this);
                });
            },

            toString: function(){
                return this.get('title');
            },

            linkTo: function(type, arg1){
                var links = {
                    "new": 'admin/projects/new',
                    "show": 'admin/projects/'+this.id,
                    "edit": 'admin/projects/'+this.id+'/edit',
                    "finance_report_by_year": "reports/projects/"+this.id+'/'+arg1
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)