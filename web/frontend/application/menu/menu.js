define(
    [
        'marionette',
        'bicycle',
        'underscore',
        'tpl!./main.tpl.html',
        'tpl!./secondary.tpl.html',
        'tpl!./breadcrumbs.tpl.html',
        'tpl!./profile.tpl.html',
        'tpl!./regionSelector.tpl.html'
    ],
    function (Marionette, Bicycle, _, Tpl_MainMenu, Tpl_SecondaryMenu, Tpl_Breadcrumbs, Tpl_Profile, Tpl_RegionSelector) {

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

            regionSelector: Marionette.ItemView.extend({
                template: Tpl_RegionSelector,

                events: {
                    //Не пашет почему то (
                    'change .j-region-selector': 'event_regionSelected'
                },

                onRender: function(){
                    this.$('.j-region-selector').change(_.bind(this.event_regionSelected, this));
                },

                event_regionSelected: function(e){
                    var region = this.model.app.collection('regions').get(this.$(e.currentTarget).val());
                    this.model.app.selectedRegion(region);
                    this.model.app.redraw();
                }
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