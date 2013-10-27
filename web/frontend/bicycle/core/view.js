define(
    ['marionette', 'backbone'],
    function (Marionette, Backbone) {
        var model = Marionette.Layout.extend({

            collectData: function () {
                return this.dataCollector_collect();
            },

            dataCollector_collect: function () {
                var data = {}
                    , _this = this
                    ;

                _(this.model.attributes).each(function (attr, key) {
                    data[key] = _this.$el.find('.j-data[data-data-attr=' + key + ']').val();
                });

                if (typeof this.dataCollector != 'undefined') {
                    _(this.dataCollector).each(function (selector, key) {
                        data[key] = this.$el.find(selector).val(); //@todo: add more magic! Type getter and html(), val(), etc
                    }, this);
                }

                delete data.id;

                return data;
            },

            //@TODO: выпилить костыль!111
            bindUIElements: function(){
                Marionette.ItemView.prototype.bindUIElements.call(this);
                this.delegateEvents();
            }

        });


        return model;
    }
)