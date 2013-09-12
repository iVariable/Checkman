define(
    [
        'bicycle',
        'tpl!./edit.tpl.html'
    ],
    function (Bicycle, TPL_Show) {

        return Bicycle.Core.View.extend({
            template: TPL_Show,

            onRender: function(){
                this.$('select').select2();
                if(this.options.drawAsWindow){
                    this.$("#modal").modal();
                }
            },

            events: {
                'click .j-save': 'event_save'
            },

            event_save: function () {
                var saving = $.Deferred(),
                    _this = this;

                if(this.options.callbacks && this.options.callbacks.saving){
                    this.options.callbacks.saving.apply(this, saving);
                }

                if(this.options.callbacks && this.options.callbacks.saved){
                    saving.done(this.options.callbacks.saved);
                }
                this.model.set(this.collectData());

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