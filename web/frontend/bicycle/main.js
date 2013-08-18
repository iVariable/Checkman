define(
    [
        './core/model',
        './core/collection',
        './core/router',
        './core/menu',

        './plugins/lazy-views'
    ],
    function(
        Model,
        Collection,
        Router,
        Menu,

        LazyViews
    ){
        var Bicycle = {
            Core: {
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