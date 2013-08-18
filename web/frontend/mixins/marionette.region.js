define(
    ['marionette'],
    function (Marionette) {
        _.extend(Marionette.Region.prototype, {

            draw: function (view) {

                this.ensureEl();

                var isViewClosed = view.isClosed || _.isUndefined(view.$el);

                var isDifferentView = view !== this.currentView;

                if (isDifferentView) {
                    this.close();
                }

                if (isDifferentView || isViewClosed) {
                    view.$el = this.$el;
                }

                view.render();

                this.currentView = view;

                Marionette.triggerMethod.call(this, "show", view);
                Marionette.triggerMethod.call(view, "show");
            }
        });

    }
)