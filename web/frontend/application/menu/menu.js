define(
    [
        'marionette',
        'bicycle',
        'underscore',
        'tpl!./main.tpl.html',
        'tpl!./secondary.tpl.html',
        'tpl!./breadcrumbs.tpl.html',
        'tpl!./profile.tpl.html'
    ],
    function (Marionette, Bicycle, _, Tpl_MainMenu, Tpl_SecondaryMenu, Tpl_Breadcrumbs, Tpl_Profile) {

        var views = {
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
        };

        var menu = Bicycle.Tools.Menu.extend({

            _init: function () {
                var _this = this;

                _(views).each(function(view, key){
                    _this.registerView(key, function () {
                        return new view({model: _this});
                    });
                });
            }
        });

        return menu;
    }
)