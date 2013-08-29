define(
    ['bicycle', './views/show'],
    function (Bicycle, View_Show) {

        var model = {

            __init: function(){
                var _this = this;
                this.registerView('show', function(){
                    return new View_Show({model:_this});
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