define(
    [
        './core/application',
        './core/model',
        './core/view',
        './core/collection',
        './core/router',
        './core/menu',

        './plugins/lazy-views/lazy-views'
    ],
    function(
        Application,
        Model,
        View,
        Collection,
        Router,
        Menu,

        LazyViews
    ){
        var Bicycle = {
            Core: {
                Application: Application,
                Model: Model,
                View: View,
                Collection: Collection,
                Router: Router
            },
            Tools: {
                Menu: Menu
            },
            Plugins: {
                LazyViews: LazyViews
            }
        };

        return Bicycle;
    }
)