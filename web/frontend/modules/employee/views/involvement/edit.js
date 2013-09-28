define(
    [
        'bicycle',
        'tpl!./edit.tpl.html'
    ],
    function (Bicycle, TPL_Show) {

        return Bicycle.Core.View.extend({
            template: TPL_Show,

            onRender: function () {
                this.modal().modal();
                window.v = this;
            },

            onClose: function() {
                this.modal().modal('hide');
            },

            modal: function() {
                return this.$("#modal");
            },

            events: {
                'click .j-save': 'event_save',
                'click .j-remove': 'event_remove',
                'click .j-add': 'event_add',
                'click .j-add-comment': 'event_add_comment'
            },

            event_add_comment: function (e) {
                this.$(e.currentTarget)
                    .hide()
                    .closest('.j-involvement')
                    .find('.j-comment')
                    .removeClass('hidden')
                ;
            },

            event_add: function () {
                this.$('.j-involvement-new').clone()
                    .removeClass('hidden')
                    .removeClass('j-involvement-new')
                    .addClass('j-involvement')
                    .find('.j-no-select2')
                        .removeClass('j-no-select2')
                        .end()
                    .appendTo('.j-involvements');
                this.$('select').not('.j-no-select2').select2();
            },

            event_remove: function (e) {
                if (confirm("Вы уверены, что хотите удалить данную занятость по проекту?")) {
                    this.$(e.currentTarget).closest('.j-involvement').remove();
                }
            },

            collectInvolvements: function () {
                var involvements = this.$('.j-involvement').map(function(){
                    var $involvementContainer = $(this);
                    var data = {
                        id: $involvementContainer.find('.j-involvement-id').val(),
                        project: $involvementContainer.find('SELECT.j-involvement-project').val(),
                        involvement: $involvementContainer.find('.j-involvement-involvement').val(),
                        notes: $involvementContainer.find('.j-involvement-notes').val()
                    };
                    return data;
                }).toArray();

                return involvements;
            },

            event_save: function () {
                var saving = $.Deferred(),
                    _this = this;

                this.$('.modal-footer .inner-well')
                    .find('.buttons')
                        .toggle()
                        .end()
                    .find('.saving')
                        .toggle()
                ;

                if (this.options.callbacks && this.options.callbacks.saving) {
                    this.options.callbacks.saving.apply(this, saving);
                }

                if (this.options.callbacks && this.options.callbacks.saved) {
                    saving.done(_.bind(this.options.callbacks.saved, _this));
                }

                this.model.set('involvementsDiff', this.collectInvolvements());

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