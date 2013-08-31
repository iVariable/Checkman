define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var translations = {
            secondName: "Фамилия",
            firstName: "Имя",
            status: "Статус",
            occupations: "Специализация",
            salary: "Зарплата",
            notes: "Заметки"
        }

        var statuses = {
            "0": "Удален",
            "1": "Активен",
            "2": "В отпуске/временно неактивен"
        };

        var fields = {
            status: {
                type: "enum",
                values: statuses
            },
            notes: {
                type: "text"
            },
            occupations: {
                type: "entity_multi",
                entityType: "occupations",
                getter: "occupations"
            }
        };

        var model = {

            defaults: {
                secondName: "",
                firstName: "",
                status: 1,
                salary: 0,
                notes: "",
                occupations: null
            },

            statuses: statuses,
            fields: fields,
            translations: translations,

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

            toString: function(){
                return this.get('secondName')+' '+this.get('firstName');
            },

            occupations: function()
            {
                var elems = _(_(this.get('occupations')).pluck('id'));
                return App.collection('occupations').filter(function(item){
                    return elems.indexOf(item.id) !== -1;
                })
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