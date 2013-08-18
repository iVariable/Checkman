define(
    [
        'marionette',
        'backbone',
        'underscore',
        'tpl!./main.tpl.html',
        'tpl!./secondary.tpl.html',
        'tpl!./breadcrumbs.tpl.html',
        'tpl!./profile.tpl.html'
    ],
    function (Marionette, Backbone, _, Tpl_MainMenu, Tpl_SecondaryMenu, Tpl_Breadcrumbs, Tpl_Profile) {

        var menu = Backbone.Model.extend({

            _views: {
                main: Marionette.ItemView.extend({
                    tagName: 'ul',
                    template: Tpl_MainMenu
                }),

                secondary: Marionette.ItemView.extend({
                    template: Tpl_SecondaryMenu
                }),

                profile: Marionette.ItemView.extend({
                    template: Tpl_Profile
                }),

                breadcrumbs: Marionette.ItemView.extend({
                    template: Tpl_Breadcrumbs
                })
            },

            view: function (name) {
                if (_.isUndefined(this.views)) this.views = {};
                if (_.isUndefined(this.views[name])) {
                    if (_.isUndefined(this._views[name])) {
                        throw Error('View [' + name + '] not found!');
                    }
                    this.views[name] = new (this._views[name])({model: this});
                }

                return this.views[name];
            },

            menu: function (menu) {
                if (!_.isUndefined(menu)) this.set('menu', menu);
                return this.get('menu');
            }

        });

        return menu;
    }
)