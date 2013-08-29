define(
    ['bicycle', 'helpers', 'application'],
    function (Bicycle, Helpers, App) {

        var model = {

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
                    return new (Helpers.View.Model.Edit)({
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
                })
            },

            toString: function(){
                return this.get('title');
            },

            linkTo: function(type){
                var links = {
                    "show": 'admin/occupations/'+this.id,
                    "edit": 'admin/occupations/'+this.id+'/edit'
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)