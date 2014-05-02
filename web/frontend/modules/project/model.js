define(
    ['bicycle', 'helpers', 'application', 'i18n!./nls/general'],
    function (Bicycle, Helpers, App, i18n) {

        var translations = i18n.model;

        var statuses = {
            "0": i18n.statuses.deleted,
            "1": i18n.statuses.active,
            "2": i18n.statuses.finished
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
                title: i18n.newModel,
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