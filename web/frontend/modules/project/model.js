define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var model = {

            defaults: {
                title: "Новый проект",
                status: 1
            },

            __init: function(){
                var _this = this;
                this.registerView('show', function(){
                    return new (Helpers.View.Model.Show)({
                        model:_this,

                        exclude: ["id"],
                        translations: {
                            title: "Название",
                            status: "Статус"
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

            linkTo: function(type){
                var links = {
                    "new": 'admin/projects/new',
                    "show": 'admin/projects/'+this.id,
                    "edit": 'admin/projects/'+this.id+'/edit'
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)