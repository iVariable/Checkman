define(
    [
        'bicycle',
        'i18n!nls/general'
    ],
    function(
        Bicycle, _i18n
    ){
        var router = Bicycle.Core.Router.extend({

            collection: function(){
                return this.app().collection('projects');
            },

            show: function(view){
                this.app().layouts.main.content.show(view);
            },

            routes : {
                "admin/projects" : "route_list"
                ,"admin/projects/new": 'route_new'
                ,"admin/projects/:id/edit": 'route_edit'
                ,"admin/projects/:id": 'route_show'
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
                this.app().menu.addBreadcrumb({ title: _i18n.actions.edit });
                this.show(model.view("edit"));

            },

            route_new: function(){
                var model = this.collection().createEntity();

                if( !model.hasView('new') ){
                    this.collection().add(model);
                    var saving = $.Deferred(),
                        _this = this;
                    this.app().loader( _i18n.actions.saving, saving.promise() );
                    saving.done(function(){
                        _this.app().router().navigate(model.linkTo('edit'), true);
                    });
                    model.save(undefined, {
                        success: function(){ saving.resolve() },
                        error: function(m, xhr){ saving.reject(xhr) },
                        wait:true
                    });
                    return '';
                }

                model.view("new").save2collection = this.collection();

                this.app().menu.addBreadcrumb({ title: model.toString() });
                this.show(model.view("new"));
            }

        });

        return router;
    }
)