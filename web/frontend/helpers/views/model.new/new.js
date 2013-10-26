define(
    [
        'bicycle',
        'tpl!./new.tpl.html'
    ],
    function (Bicycle, TPL_Show) {

        return Bicycle.Core.View.extend({
            template: TPL_Show,

            onRender: function(){
                this.$('select').select2();
            },

            events: {
                'click .j-save': 'event_save'
            },

            event_save: function () {
                var saving = $.Deferred(),
                    _this = this;

                this.$('.j-buttons').html('<p style="text-align: center">Сохранение...</p>');

                if(this.options.callbacks && this.options.callbacks.saving){
                    this.options.callbacks.saving.call(this, saving);
                }

                if(this.options.callbacks && this.options.callbacks.saved){
                    saving.done(_.bind(this.options.callbacks.saved, this.model));
                }

                this.model.set(this.collectData());

                this.save2collection.add(this.model);

                this.model.save(undefined, {
                    success: function () {
                        saving.resolve();
                    },
                    error: function (m, xhr) {
                        saving.reject(xhr)
                    },
                    wait: true
                });
                return saving.promise();
            }
        });

    }
)