define(
    [
        'marionette',
        'bicycle',
        'underscore',
        'tpl!./main.tpl.html',
        'tpl!./secondary.tpl.html',
        'tpl!./breadcrumbs.tpl.html',
        'tpl!./profile.tpl.html',
        'tpl!./regionSelector.tpl.html',
        'i18n!./../nls/general'
    ],
    function (Marionette, Bicycle, _, Tpl_MainMenu, Tpl_SecondaryMenu, Tpl_Breadcrumbs, Tpl_Profile, Tpl_RegionSelector, i18n) {

        var views = {
            main: Marionette.ItemView.extend({
                tagName: 'ul',
                template: Tpl_MainMenu
            }),

            secondary: Marionette.ItemView.extend({
                template: Tpl_SecondaryMenu
            }),

            profile: Marionette.ItemView.extend({
                template: Tpl_Profile,
                _serializeAdditionalData: {
                    i18n: i18n.menu
                }
            }),

            regionSelector: Marionette.ItemView.extend({
                template: Tpl_RegionSelector,
                _serializeAdditionalData: {
                    i18n: i18n.menu
                }
            }),

            breadcrumbs: Marionette.ItemView.extend({
                template: Tpl_Breadcrumbs,
                _serializeAdditionalData: {
                    i18n: i18n.menu
                }
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