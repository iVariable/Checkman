define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var translations = {
            title: "Название",
            status: "Статус",
            region_id: "Регион (общие расходы)",
            description: "Описание"
        };


        var statuses = {
            "0": "Удален",
            "1": "Активен",
            "2": "Завершен"
        };

        var fields = {
            status: {
                type: "enum",
                values: statuses
            },
            region_id: {
                type: "entity",
                entityType: "regions",
                getter: "region",
                nullable: true
            },
            description: {
                type: "text"
            }
        };


        var model = {

            defaults: {
                title: "Новый проект",
                status: 1,
                region_id: null,
                description: ""
            },

            statuses: statuses,

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

            region: function (){
                return App.collection('regions').get(this.get('region_id'));
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

            linkTo: function(type, arg1, arg2){
                var links = {
                    "new": 'admin/projects/new',
                    "show": 'admin/projects/'+this.id,
                    "edit": 'admin/projects/'+this.id+'/edit',
                    "finance_report_by_year": "reports/projects/"+this.id+'/'+arg1,
                    "finance_report_by_year_month": "reports/projects/"+this.id+'/'+arg1+"/"+arg2
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)