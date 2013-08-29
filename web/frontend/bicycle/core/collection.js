define(
    ['backbone', './../plugins/lazy-views/lazy-views'],
    function(Backbone, LazyViews){
        var model = Backbone.Collection.extend( {

            initialize: function(args, opts){
                this.__init(args, opts);
            },

            __init: function(args, opts){},

            createEntity: function(args){
                return new (this.model)(args);
            },

            getLink: function(){ return ''; }

        });

        model = model.extend(LazyViews);

        return model;
    }
)