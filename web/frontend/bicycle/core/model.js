define(
    ['backbone', './../plugins/lazy-views'],
    function(Backbone, LazyViews){
        var model = Backbone.Model.extend( LazyViews, {

            initialize: function(args, opts){
                this.__init(args, opts);
            },

            __init: function(args, opts){}

        });
        return model;
    }
)