define(
    [
        'bicycle',
        'tpl!./new.tpl.html',
        'i18n!nls/general'
    ],
    function (Bicycle, TPL_Show, i18n) {

        return Bicycle.Core.View.extend({
            template: TPL_Show,
            _serializeAdditionalData: {
                i18n: i18n
            },

            onRender: function () {
                this.$('select').select2();
            },

            events: {
                'click .j-save': 'event_save',
                'click .j-cancel': 'event_cancel'
            },

            event_cancel: function (e) {
                if (this.options.callbacks && this.options.callbacks.cancelled) {
                    this.options.callbacks.cancelled.call(this);
                    e.preventDefault();
                    return false;
                }
            },

            event_save: function () {
                var saving = $.Deferred(),
                    _this = this;

                this.$('.j-buttons').html('<p style="text-align: center">' + i18n.actions.saving + '...</p>');

                if (this.options.callbacks && this.options.callbacks.saving) {
                    this.options.callbacks.saving.call(this, saving);
                }

                if (this.options.callbacks && this.options.callbacks.saved) {
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