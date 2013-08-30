define(
    [
        'bicycle',
        'tpl!./list.tpl.html'
    ],
    function (Bicycle, TPL_List) {


        return Bicycle.Core.View.extend({
            template: TPL_List,

            events: {
                'click .j-new-occupation': "event_newModel",
                'click .j-edit-occupation': "event_editModel",
                'click .j-remove-occupation': "event_removeModel"
            },

            event_newModel: function(){},
            event_editModel: function(){},
            event_removeModel: function(e){
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

                    //this.app().loader( 'Удаление сущности', removed.promise() );
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