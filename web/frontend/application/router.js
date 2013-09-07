define(
    [
        'bicycle',

        './views/dashboard',
        './views/listRoutes'
    ],
    function (Bicycle, View_Dashboard, View_ListRoutes) {
        var router = Bicycle.Core.Router.extend({
            routes: {
                "": "route_dashboard"
                ,"reports": "route_list"
                ,"admin": "route_list"
            },
            route_dashboard: function () {
                //this.app().layouts.main.content.show(new View_Dashboard());
                var item = this.app().menu.selectedItem();
                this.app().layouts.main.content.show(new View_ListRoutes(item));
            },

            route_list: function () {
                var item = this.app().menu.selectedItem();
                this.app().layouts.main.content.show(new View_ListRoutes(item));
            }

        });

        return router;
    }
)