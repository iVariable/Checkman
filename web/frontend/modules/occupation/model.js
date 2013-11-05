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
                    "PHP разработчик": "PHP"
                    ,"Системный аналитик": "А"
                    ,"Верстальщик": "HTML"
                    ,"Тестировщик": "QA"
                    ,"Дизайнер": "PSD"
                    ,"JS разработчик": "JS"
                    ,"iOS разработчик": "iOS"
                    ,"Android разработчик": "And"
                    ,"WinPhone разработчик": "Win"
                    ,".NET разработчик": ".NET"
                    ,"JAVA разработчик": "JAVA"
                    ,"Менеджер проекта": "PM"
                    ,"Системный администратор": "ADMIN"
                    ,"Офис-менеджер": "OFFICE"
                    ,"Региональный руководитель": "BOSS"
                };

                return titles[this.get('title')]?titles[this.get('title')]:this.get('title');
            },

            abbr: function(){
                var titles = {
                    "PHP разработчик": "php"
                    ,"Аналитик": "analytics"
                    ,"Верстальщик": "html"
                    ,"Тестировщик": "qa"
                    ,"Дизайнер": "psd"
                    ,"Разработчик. JS": "js"
                    ,".NET разработчик": "dotnet"
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