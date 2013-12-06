define(
    ['bicycle', 'helpers', 'application', './views/involvement/edit'],
    function (Bicycle, Helpers, App, View_InvolvementEdit) {

        var translations = {
            secondName: "Фамилия",
            firstName: "Имя",
            status: "Статус",
            occupations: "Специализация",
            salary: "Зарплата",
            notes: "Заметки",
            projects: "Проекты",
            region_id: "Регион"
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
            },
            region_id: {
                type: "entity",
                entityType: "regions",
                getter: "region"
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
                salary: 0,
                region_id: null
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

                        fields: fields,

                        htmlInclude: {
                            footer: function(model) {
                                return '<tr><th>Стоимость дня работы</th><td>'+_.currencyFormat(model.get('salary')/30)+'</td></tr>' +
                                    '<tr><th>Стоимость часа работы</th><td>'+_.currencyFormat(model.get('salary')/30/8)+'</td></tr>'
                                ;
                            }
                        }
                    });
                });

                this.registerView('involvement', function(){
                    return new View_InvolvementEdit({
                        model: _this,

                        callbacks: {
                            saved: function(){
                                //Parasha sranaia
                                App.layouts.main.modalWindowContainer.reset();
                                App.reload();
                            },

                            saving: function(xhr){
                                App.loader('Сохраняем занятость сотрудника', xhr);
                            }
                        }
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

            status: function(){
                return statuses[this.get('status')];
            },

            toString: function () {
                return this.get('secondName') + ' ' + this.get('firstName') + ' ['+this.region()+']';
            },

            hasOccupation: function(occupation){
                return this.get('occupations').indexOf(occupation.id) != -1;
            },

            occupations: function () {
                var elems = _(this.get('occupations'));
                return App.collection('occupations').filter(function (item) {
                    return elems.indexOf(item.id) !== -1;
                })
            },

            projects: function () {
                return this.involvements().map(function(involvement){ return involvement.project(); });
            },

            region: function (){
                return App.collection('regions').get(this.get('region_id'));
            },

            involvements: function () {

                var elems = _(this.get('projects'));

                var involvementsRaw = App.collection('projectInvolvements').filter(function (item) {
                    return elems.indexOf(item.id) !== -1;
                })

                var involvements = new (App.module('projectInvolvement').Collection)(_(involvementsRaw).pluck('attributes'));
                return involvements;
            },

            involvementByProject: function(project){
                return this.involvements().find(function (projectInvolvement) {
                    return projectInvolvement.get('project') == project.id;
                });
            },

            involvement: function (project) {
                var involvement = this.involvementByProject(project);
                return involvement ? involvement.get('involvement') : false;
            },

            freetime: function() {
                var free = 100 - (
                    this.involvements()
                    .reduceRight(
                        function(val, inv){ return val+parseInt(inv.get('involvement')); },
                        0
                    )
                );

                if (free < 5) free = 0;
                return free;
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