define(
    ['backbone', './../plugins/lazy-views/lazy-views'],
    function(Backbone, LazyViews){
        var model = Backbone.Model.extend( {

            initialize: function(args, opts){
                this.__init(args, opts);
            },

            __init: function(args, opts){},

            linkTo: function(){
                return '';
            }

        });

        model = model.extend(LazyViews);

        return model;
    }
)