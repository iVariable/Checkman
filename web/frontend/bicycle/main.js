define(
    [
        './core/model',
        './core/router',
        './core/menu',

        './plugins/lazy-views'
    ],
    function(
        Model,
        Router,
        Menu,

        LazyViews
    ){
        var Bicycle = {
            Core: {
                Model: Model,
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