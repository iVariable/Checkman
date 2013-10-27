define(
    [
        'marionette',
        'tpl!./edit-list.tpl.html',
        'application'
    ],
    function (Marionette, TPL_List, App) {

        return Marionette.ItemView.extend({
            template: TPL_List,

            events: {
                'click .j-remove': 'event_remove'
            },

            event_remove: function(e){
                var id = $(e.currentTarget).data('id'),
                    model = this.model.get(id);
                if( !model ) throw Error('Model not found');
                if( confirm( 'Вы действительно хотите удалить "'+model+'"?' ) ){
                    var removed = $.Deferred(),
                        _this = this;
                    removed.done(function(){
                        _this.render();
                    })

                    if(this.options.callbacks && this.options.callbacks.removing){
                        this.options.callbacks.removing.apply(this, removed);
                    }

                    if(this.options.callbacks && this.options.callbacks.removed){
                        removed.done(this.options.callbacks.removed);
                    }

                    App.loader( 'Удаление сущности', removed.promise() );
                    model.destroy({
                        success: function(){
                            removed.resolve();
                        },
                        error: function(m, xhr){
                            removed.reject(xhr);
                        },
                        wait: true
                    });
                }
            }
        });

    }
)