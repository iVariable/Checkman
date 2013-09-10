define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var model = {

            defaults: {
                title: "Новая специализация"
            },

            __init: function(){
                var _this = this;
                this.registerView('show', function(){
                    return new (Helpers.View.Model.Show)({
                        model:_this,

                        exclude: ["id"],
                        translations: {
                            title: "Название"
                        }
                    });
                });

                this.registerView('edit', function(){
                    var view = new (Helpers.View.Model.Edit)({
                        model:_this,

                        exclude: ["id"],
                        translations: {
                            title: "Название"
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
                            title: "Название"
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

            shortTitle: function(){
                var titles = {
                    "Разработчик. PHP": "PHP"
                    ,"Аналитик": "А"
                    ,"Верстальщик": "HTML"
                    ,"Тестировщик": "QA"
                    ,"Дизайнер": "PSD"
                    ,"Разработчик. JS": "JS"
                    ,"Разработчик. .NET": ".NET"
                    ,"Разработчик. JAVA": "JAVA"
                    ,"Менеджер проектов": "PM"
                    ,"Системный администратор": "ADMIN"
                    ,"Администратор офиса": "OFFICE"
                    ,"Руководитель": "BOSS"
                };

                return titles[this.get('title')]?titles[this.get('title')]:this.get('title');
            },

            abbr: function(){
                var titles = {
                    "Разработчик. PHP": "php"
                    ,"Аналитик": "analytics"
                    ,"Верстальщик": "html"
                    ,"Тестировщик": "qa"
                    ,"Дизайнер": "psd"
                    ,"Разработчик. JS": "js"
                    ,"Разработчик. .NET": "dotnet"
                };

                return titles[this.get('title')]?titles[this.get('title')]:'free';
            },

            linkTo: function(type){
                var links = {
                    "new": 'admin/occupations/new',
                    "show": 'admin/occupations/'+this.id,
                    "edit": 'admin/occupations/'+this.id+'/edit'
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)