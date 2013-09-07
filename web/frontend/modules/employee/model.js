define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var translations = {
            secondName: "Фамилия",
            firstName: "Имя",
            status: "Статус",
            occupations: "Специализация",
            salary: "Зарплата",
            notes: "Заметки",
            projects: "Проекты"
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
            },
            projects: {
                type: "involvement",
                entityType: "project",
                getter: "projects"
            }
        };

        var model = {

            defaults: {
                secondName: "",
                firstName: "",
                status: 1,
                notes: "",
                occupations: null,
                projects: null,
                salary: 0
            },

            statuses: statuses,
            fields: fields,
            translations: translations,

            __init: function () {
                var _this = this;
                this.registerView('show', function () {
                    return new (Helpers.View.Model.Show)({
                        model: _this,

                        exclude: ["id"],
                        translations: translations,

                        fields: fields
                    });
                });

                this.registerView('edit', function () {
                    var view = new (Helpers.View.Model.Edit)({
                        model: _this,

                        exclude: ["id", "projects"],
                        translations: translations,

                        fields: fields,

                        callbacks: {
                            saved: function () {
                                App.router.navigate(_this.linkTo('show'), true);
                            }
                        }
                    });

                    view.on('render', function () {
                        view.delegateEvents();
                    })
                    return view;
                })

                this.registerView('new', function () {
                    var view = new (Helpers.View.Model.New)({
                        model: _this,

                        exclude: ["id", "projects"],
                        translations: translations,

                        fields: fields,

                        callbacks: {
                            saved: function () {
                                App.router.navigate(_this.linkTo('show'), true);
                            }
                        }
                    });

                    view.on('render', function () {
                        view.delegateEvents();
                    })
                    return view;
                })
            },

            toString: function () {
                return this.get('secondName') + ' ' + this.get('firstName');
            },

            occupations: function () {
                var elems = _(_(this.get('occupations')).pluck('id'));
                return App.collection('occupations').filter(function (item) {
                    return elems.indexOf(item.id) !== -1;
                })
            },

            projects: function () {
                var elems = _(_(this.get('projects')).pluck('project_id'));
                return App.collection('projects').filter(function (item) {
                    return elems.indexOf(item.id) !== -1;
                })
            },

            involvements: function () {
                var involvements = _(this.get('projects')).map(function(data){
                    return new (App.module('projectInvolvement').Model)(data);
                });
                return involvements;
            },

            involvement: function (project) {
                var involvement = _(this.get('projects')).find(function (projectInvolvement) {
                    return projectInvolvement.project_id == project.id;
                });
                return involvement ? involvement.involvement : false;
            },

            freetime: function() {
                return 100 - (
                    _(this.involvements())
                        .reduceRight(
                            function(val, inv){ return val+parseInt(inv.get('involvement')); },
                            0
                        )
                );
            },

            linkTo: function (type) {
                var links = {
                    "new": 'admin/employees/new',
                    "show": 'admin/employees/' + this.id,
                    "edit": 'admin/employees/' + this.id + '/edit'
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)