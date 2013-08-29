define(
    [
        'bicycle'
    ],
    function(
        Bicycle,

        View_List
    ){
        var router = Bicycle.Core.Router.extend({

            collection: function(){
                return this.app().collection('occupations');
            },

            show: function(view){
                this.app().layouts.main.content.show(view);
            },

            routes : {
                "admin/occupations" : "route_list"
                ,"admin/occupations/new": 'route_new'
                ,"admin/occupations/:id/edit": 'route_edit'
                ,"admin/occupations/:id": 'route_show'
            },

            route_list : function(){
                this.show( this.collection().view('list') );
            },

            route_show: function(id){
                var model = this.collection().get(id);
                this.app().menu.addBreadcrumb({ title: model.toString() });
                this.show(model.view("show"));
            },

            route_edit: function(id){
                var model = this.collection().get(id);
                this.app().menu.addBreadcrumb({ title: model.toString(), url: model.linkTo('show') });
                this.app().menu.addBreadcrumb({ title: "Редактирование" });
                this.show(model.view("show"));

            },

            route_new: function(){
                //spawn model and check "new" view existance
                //this.collection().mol
            }

        });

        return router;
    }
)