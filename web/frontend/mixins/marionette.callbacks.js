define(
    ['marionette'],
    function(Marionette){

        _.extend(Marionette.Callbacks.prototype, {

            // Add a callback to be executed. Callbacks added here are
            // guaranteed to execute, even if they are added after the
            // `run` method is called.
            add: function(callback, contextOverride){
                var _this = this;
                this._done = this._done || Marionette.$.Deferred();
                this._callbacksStatus = this._callbacksStatus || [];
                this._callbacks.push({cb: callback, ctx: contextOverride});

                this._deferred.done(function(context, options){
                    if (contextOverride){ context = contextOverride; }
                    _this._callbacksStatus.push(callback.call(context, options));
                });
            },

            // Run all registered callbacks with the context specified.
            // Additional callbacks can be added after this has been run
            // and they will still be executed.
            run: function(options, context){
                var _this = this;
                this._done = this._done || Marionette.$.Deferred();
                this._callbacksStatus = this._callbacksStatus || [];
                this._deferred.resolve(context, options);
                $.when.apply($, this._callbacksStatus)
                    .done(function(){
                        _this._done.resolve();
                    })
                    .fail(function(){
                        _this._done.reject();
                    })
                return this._done;
            },

            // Resets the list of callbacks to be run, allowing the same list
            // to be run multiple times - whenever the `run` method is called.
            reset: function(){
                var callbacks = this._callbacks;
                this._done = Marionette.$.Deferred();
                this._deferred = Marionette.$.Deferred();
                this._callbacks = [];
                this._callbacksStatus = [];

                _.each(callbacks, function(cb){
                    this.add(cb.cb, cb.ctx);
                }, this);
            },

            done: function(){
                this._done.done.call(this._done);
            },

            always: function(){
                this._done.always.call(this._done);
            },

            fail: function(){
                this._done.fail.call(this._done);
            }
        })

    }
)