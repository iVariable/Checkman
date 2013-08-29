define(
    [
        './core/application',
        './core/model',
        './core/collection',
        './core/router',
        './core/menu',

        './plugins/lazy-views/lazy-views'
    ],
    function(
        Application,
        Model,
        Collection,
        Router,
        Menu,

        LazyViews
    ){
        var Bicycle = {
            Core: {
                Application: Application,
                Model: Model,
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