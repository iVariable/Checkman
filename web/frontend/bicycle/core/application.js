define(
    ['marionette'],
    function(Marionette){
        var model = Marionette.Application.extend( {

            initialize: function(args, opts){
                this.__init(args, opts);
            },

            __init: function(args, opts){},

            _collections: null,

            collection: function(name, collection){
                this._collections = this._collections || {};
                if(!_.isUndefined(collection)){
                    this._collections[name] = collection;
                }
                return this._collections[name];
            },

            collections: function() {
                this._collections = this._collections || {};
                return this._collections;
            },

            loader: function(title, xhr){
                return xhr;
            },

            start: function(options){
                var _this = this;
                this.triggerMethod("initialize:before", options);
                this._initCallbacks.run(options, this).always(function(){
                    _this.triggerMethod("initialize:after", options);

                    _this.triggerMethod("start", options);
                });

            }

        });

        return model;
    }
)