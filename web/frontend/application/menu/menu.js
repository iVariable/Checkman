define(
    [
        'marionette',
        'backbone',
        'underscore',
        'tpl!./main.tpl.html',
        'tpl!./secondary.tpl.html'
    ],
    function (Marionette, Backbone, _, Tpl_MainMenuTemplate, Tpl_SecondaryMenuTemplate) {

        var menu = Backbone.Model.extend({

            _views: {
                main: Marionette.ItemView.extend({
                    tagName: 'ul',
                    template: Tpl_MainMenuTemplate
                }),

                secondary: Marionette.ItemView.extend({
                    template: Tpl_SecondaryMenuTemplate
                })
            },

            view: function (name) {
                if (_.isUndefined(this.views)) this.views = {};
                if (_.isUndefined(this.views[name])) {
                    if (_.isUndefined(this._views[name])){
                        throw Error('View ['+name+'] not found!');
                    }
                    this.views[name] = new (this._views[name])({model: this});
                }

                return this.views[name];
            }

        });

        return menu;
    }
)