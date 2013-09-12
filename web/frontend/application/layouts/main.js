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
                breadcrumbs: "#main>.top-nav .breadcrumb",
                content: "#main>.a-main-container",
                modalWindowContainer: "#main>.a-modal-window-container"
            }
        });

        return {
            MainLayout: MainLayout
        }
    }
)