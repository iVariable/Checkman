define(
    [
        'bicycle',
        'tpl!./list.tpl.html',
        'application',
        'i18n!nls/general'
    ],
    function (Bicycle, TPL_List, App, i18n) {


        return Bicycle.Core.View.extend({
            template: TPL_List,
            _serializeAdditionalData: {
                i18n: i18n
            },

            events: {
                'click .j-new-occupation': "event_newModel",
                'click .j-edit-occupation': "event_editModel",
                'click .j-remove-occupation': "event_removeModel",
                'keyup .j-filter-by': 'event_filter'
            },

            event_filter: function () {
                var filter = this.$('.j-filter-by').val().toLowerCase();
                if (filter == "") {
                    this.$('table tbody .j-filterable').show();
                } else {
                    this.$('table tbody .j-filterable').not('[data-filter-by*='+filter+']').hide();
                }
            },

            event_newModel: function(){},
            event_editModel: function(){},
            event_removeModel: function(e){
                var id = $(e.currentTarget).data('id'),
                    model = this.model.get(id);
                if( !model ) throw Error('Model not found');
                if( confirm( i18n.helpers.deleteConfirmation + ' "'+model+'"?' ) ){
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

                    App.loader( i18n.actions.deleting, removed.promise() );
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