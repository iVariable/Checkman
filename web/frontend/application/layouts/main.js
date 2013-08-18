define(
    [
        'marionette',
        'tpl!./main.tpl.html'
    ],
    function (Marionette, Tpl_MainLayout) {
        var MainLayout = Marionette.Layout.extend({
            template: Tpl_MainLayout,

            regions: {
                primaryMenu: "#primary",
                secondaryMenu: "#secondary>.secondary-nav-menu",
                profile: "#secondary>.profile-menu",
                crumbs: "#main>.top-nav",
                container: "#main>.a-main-container"
            }
        });


        return {
            MainLayout: MainLayout
        }
    }
)