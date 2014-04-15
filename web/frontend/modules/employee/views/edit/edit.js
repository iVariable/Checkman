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
                'click .j-save': 'event_save',
                'keyup .j-data[name=salary]': 'event_salaryNet'
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
            },

            event_salaryNet: function(e){
                var salary = parseFloat(this.$('.j-data[name=salary]').val());
                this.$('.j-salary-net').val(_.currencyFormat(salary * 0.87));
            }
        });

    }
)