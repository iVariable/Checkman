define(
    [
        './core/model',
        './core/menu',

        './plugins/lazy-views'
    ],
    function(
        Model,
        Menu,

        LazyViews
    ){
        var Bicycle = {
            Core: {
                Model: Model
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